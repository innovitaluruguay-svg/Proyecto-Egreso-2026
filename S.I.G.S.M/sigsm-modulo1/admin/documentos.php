<?php
$titulo_pagina = 'Gestión de documentos';
require_once __DIR__ . '/_header.php';
require_once __DIR__ . '/../config/functions.php';
$msg = '';
$error = '';
$categorias = $pdo->query("SELECT id,nombre FROM categorias WHERE activo=1 ORDER BY nombre")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!verificar_csrf($_POST['csrf'] ?? '')) {
    $error = 'Solicitud no válida.';
  } else {
    $accion = $_POST['accion'] ?? '';
    if ($accion === 'crear') {
      $titulo = trim($_POST['titulo'] ?? '');
      $descripcion = trim($_POST['descripcion'] ?? '');
      $categoria = (int)($_POST['categoria_id'] ?? 0);
      $archivo = $_FILES['archivo'] ?? null;
      if ($titulo === '' || $categoria <= 0 || !pdf_valido($archivo)) $error = 'Complete los datos y seleccione un PDF válido de hasta 10 MB.';
      else {
        $nombre = bin2hex(random_bytes(12)) . '.pdf';
        $destino = __DIR__ . '/../public/storage/documentos/' . $nombre;
        if (move_uploaded_file($archivo['tmp_name'], $destino)) {
          $stmt = $pdo->prepare('INSERT INTO documentos(titulo,descripcion,archivo,categoria_id) VALUES(?,?,?,?)');
          $stmt->execute([$titulo, $descripcion, $nombre, $categoria]);
          guardar_auditoria($pdo, $_SESSION['usuario_id'], 'CREAR', 'DOCUMENTOS', 'Creó documento: ' . $titulo);
          $msg = 'Documento publicado correctamente.';
        } else $error = 'No se pudo guardar el PDF.';
      }
    }
    if ($accion === 'estado') {
      $id = (int)($_POST['id'] ?? 0);
      $estado = (int)($_POST['estado'] ?? 0);
      $stmt = $pdo->prepare('UPDATE documentos SET activo=? WHERE id=?');
      $stmt->execute([$estado, $id]);
      guardar_auditoria($pdo, $_SESSION['usuario_id'], $estado ? 'ACTIVAR' : 'DESACTIVAR', 'DOCUMENTOS', 'Documento ID ' . $id);
      $msg = 'Estado actualizado.';
    }
  }
}
$docs = $pdo->query('SELECT d.*,c.nombre categoria FROM documentos d JOIN categorias c ON c.id=d.categoria_id ORDER BY d.fecha_actualizacion DESC')->fetchAll();
?>
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h1 class="h2">Gestión de documentos</h1>
    <p class="text-muted mb-0">Suba, actualice o desactive documentación para pacientes.</p>
  </div><a class="btn btn-outline-secondary" href="<?= url('admin/dashboard.php') ?>">Volver</a>
</div>
<?php if ($msg): ?><div class="alert alert-success"><?= e($msg) ?></div><?php endif; ?><?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
<div class="card border-0 shadow-sm mb-4">
  <div class="card-body p-4">
    <h2 class="h5">Nuevo documento</h2>
    <form method="post" enctype="multipart/form-data" class="row g-3"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><input type="hidden" name="accion" value="crear">
      <div class="col-md-6"><label class="form-label">Título *</label><input class="form-control" name="titulo" required></div>
      <div class="col-md-6"><label class="form-label">Categoría *</label><select class="form-select" name="categoria_id" required>
          <option value="">Seleccione...</option><?php foreach ($categorias as $c): ?><option value="<?= $c['id'] ?>"><?= e($c['nombre']) ?></option><?php endforeach; ?>
        </select></div>
      <div class="col-12"><label class="form-label">Descripción</label><textarea class="form-control" name="descripcion" rows="3"></textarea></div>
      <div class="col-md-8"><label class="form-label">PDF *</label><input class="form-control" name="archivo" type="file" accept="application/pdf,.pdf" required>
        <div class="form-text">Máximo 10 MB.</div>
      </div>
      <div class="col-md-4 d-flex align-items-end"><button class="btn btn-primary w-100"><i class="bi bi-upload me-2"></i>Publicar</button></div>
    </form>
  </div>
</div>
<div class="card border-0 shadow-sm">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>Título</th>
          <th>Categoría</th>
          
          <th>Estado</th>
          <th>Actualización</th>
          <th class="text-end">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($docs as $d): ?><tr>
            <td><?= e($d['titulo']) ?></td>
            <td><?= e($d['categoria']) ?></td>
            <td></td>
            <td><?= $d['activo'] ? '<span class="badge text-bg-success">Activo</span>' : '<span class="badge text-bg-secondary">Inactivo</span>' ?></td>
            <td><?= e($d['fecha_actualizacion']) ?></td>
            <td class="text-end">
              <a class="btn btn-sm btn-outline-primary" target="_blank" href="<?= url('paciente/documento.php?id=' . $d['id']) ?>">Ver</a>
              <a class="btn btn-sm btn-outline-dark btn-qr"
                 href="#"
                 data-qr-url="<?= e(url_publica('paciente/documento.php?id=' . $d['id'])) ?>"
                 data-qr-title="<?= e($d['titulo']) ?>">
                <i class="bi bi-qr-code me-1"></i>QR
              </a>
              <a class="btn btn-sm btn-outline-secondary" href="<?= url('admin/editar_documento.php?id=' . $d['id']) ?>">Editar</a>
              <form class="d-inline" method="post"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><input type="hidden" name="accion" value="estado"><input type="hidden" name="id" value="<?= $d['id'] ?>"><input type="hidden" name="estado" value="<?= $d['activo'] ? 0 : 1 ?>"><button class="btn btn-sm <?= $d['activo'] ? 'btn-outline-danger' : 'btn-outline-success' ?>"><?= $d['activo'] ? 'Desactivar' : 'Activar' ?></button></form>
            </td>
          </tr><?php endforeach; ?>
        <?php if (!$docs): ?><tr>
            <td colspan="6" class="text-center text-muted py-4">No hay documentos cargados.</td>
          </tr><?php endif; ?></tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="qrModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Código QR del documento</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body text-center">
        <h3 id="qrTitulo" class="h6"></h3>
        <div id="qrCode" class="d-flex justify-content-center my-3"></div>
        <p class="small text-muted mb-2">Escanee este código con el celular para abrir el documento.</p>
        <input id="qrUrl" class="form-control form-control-sm" readonly>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" onclick="imprimirQR()">Imprimir</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
<script>
let qrActual = null;

document.querySelectorAll('.btn-qr').forEach(function(boton) {
  boton.addEventListener('click', function(evento) {
    evento.preventDefault();

    const url = this.dataset.qrUrl;
    const titulo = this.dataset.qrTitle;

    document.getElementById('qrTitulo').textContent = titulo;
    document.getElementById('qrUrl').value = url;
    document.getElementById('qrCode').innerHTML = '';

    qrActual = new QRCode(document.getElementById('qrCode'), {
      text: url,
      width: 220,
      height: 220
    });

    bootstrap.Modal.getOrCreateInstance(document.getElementById('qrModal')).show();
  });
});

function imprimirQR() {
  const titulo = document.getElementById('qrTitulo').textContent;
  const url = document.getElementById('qrUrl').value;

  const ventana = window.open('', '_blank');
  ventana.document.write(`
    <html>
      <head>
        <title>QR - ${titulo}</title>
        <style>
          body { font-family: Arial, sans-serif; text-align: center; padding: 30px; }
          h1 { font-size: 20px; }
          img { margin: 20px; }
          p { word-break: break-all; color: #555; }
        </style>
      </head>
      <body>
        <h1>${titulo}</h1>
        <div id="printQr"></div>
        <p>${url}</p>
        <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"><\/script>
        <script>
          new QRCode(document.getElementById('printQr'), { text: ${JSON.stringify(url)}, width: 300, height: 300 });
          setTimeout(() => window.print(), 500);
        <\/script>
      </body>
    </html>
  `);
  ventana.document.close();
}
</script>

<?php require_once __DIR__ . '/_footer.php'; ?>