<?php
$titulo_pagina = 'Editar documento';
require_once __DIR__ . '/_header.php';
require_once __DIR__ . '/../config/functions.php';

$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);

$stmt = $pdo->prepare('SELECT * FROM documentos WHERE id=?');
$stmt->execute([$id]);
$doc = $stmt->fetch();

if (!$doc) {
    exit('Documento no encontrado.');
}

$cats = $pdo->query('SELECT id,nombre FROM categorias WHERE activo=1 ORDER BY nombre')->fetchAll();
$msg = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verificar_csrf($_POST['csrf'] ?? '')) {
        $error = 'Solicitud no válida.';
    } else {
        $titulo = trim($_POST['titulo'] ?? '');
        $desc = trim($_POST['descripcion'] ?? '');
        $cat = (int)($_POST['categoria_id'] ?? 0);
        $nuevo = $_FILES['archivo'] ?? null;

        if ($titulo === '' || $cat <= 0) {
            $error = 'Complete los campos obligatorios.';
        } else {
            $archivoActual = $doc['archivo'];

            if ($nuevo && ($nuevo['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
                if (!pdf_valido($nuevo)) {
                    $error = 'El nuevo archivo debe ser PDF y tener máximo 10 MB.';
                } else {
                    $nombre = bin2hex(random_bytes(12)) . '.pdf';
                    $destino = __DIR__ . '/../public/storage/documentos/' . $nombre;

                    if (move_uploaded_file($nuevo['tmp_name'], $destino)) {
                        $archivoAnterior = __DIR__ . '/../public/storage/documentos/' . $doc['archivo'];
                        if (is_file($archivoAnterior)) {
                            @unlink($archivoAnterior);
                        }
                        $archivoActual = $nombre;
                    } else {
                        $error = 'No se pudo guardar el nuevo PDF.';
                    }
                }
            }

            if ($error === '') {
                $pdo->prepare(
                    'UPDATE documentos SET titulo=?, descripcion=?, categoria_id=?, archivo=? WHERE id=?'
                )->execute([$titulo, $desc, $cat, $archivoActual, $id]);

                guardar_auditoria(
                    $pdo,
                    $_SESSION['usuario_id'],
                    'EDITAR',
                    'DOCUMENTOS',
                    'Documento ID ' . $id . ' actualizado'
                );

                $msg = 'Documento actualizado correctamente.';

                $stmt = $pdo->prepare('SELECT * FROM documentos WHERE id=?');
                $stmt->execute([$id]);
                $doc = $stmt->fetch();
            }
        }
    }
}
?>
<div class="mb-4">
  <a href="<?= url('admin/documentos.php') ?>" class="btn btn-outline-secondary mb-3">Volver</a>
  <h1 class="h2">Editar documento</h1>
  <p class="text-muted">Puede cambiar la información o reemplazar el PDF actual.</p>
</div>

<?php if ($msg): ?>
  <div class="alert alert-success"><?= e($msg) ?></div>
<?php endif; ?>

<?php if ($error): ?>
  <div class="alert alert-danger"><?= e($error) ?></div>
<?php endif; ?>

<div class="card border-0 shadow-sm">
  <div class="card-body p-4">
    <form method="post" enctype="multipart/form-data" class="row g-3">
      <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
      <input type="hidden" name="id" value="<?= $doc['id'] ?>">

      <div class="col-md-8">
        <label class="form-label">Título *</label>
        <input class="form-control" name="titulo" value="<?= e($doc['titulo']) ?>" required>
      </div>

      <div class="col-md-4">
        <label class="form-label">Categoría *</label>
        <select class="form-select" name="categoria_id" required>
          <?php foreach ($cats as $c): ?>
            <option value="<?= $c['id'] ?>" <?= $doc['categoria_id'] == $c['id'] ? 'selected' : '' ?>>
              <?= e($c['nombre']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-12">
        <label class="form-label">Descripción</label>
        <textarea class="form-control" name="descripcion" rows="3"><?= e($doc['descripcion']) ?></textarea>
      </div>

      <div class="col-12">
        <div class="alert alert-light border mb-0">
          <strong>Archivo actual:</strong>
          <a href="<?= url('paciente/documento.php?id=' . $doc['id']) ?>" target="_blank">Ver documento</a>
        </div>
      </div>

      <div class="col-12">
        <label class="form-label">Reemplazar PDF (opcional)</label>
        <input class="form-control" name="archivo" type="file" accept="application/pdf,.pdf">
        <div class="form-text">Máximo 10 MB.</div>
      </div>

      <div class="col-12">
        <button class="btn btn-primary">
          <i class="bi bi-save me-1"></i>Guardar cambios
        </button>
      </div>
    </form>
  </div>
</div>
<?php require_once __DIR__ . '/_footer.php'; ?>
