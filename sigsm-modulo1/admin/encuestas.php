<?php
$titulo_pagina = 'Encuestas';
require_once __DIR__ . '/_header.php';
require_once __DIR__ . '/../config/functions.php';
$msg = '';
$error = '';
exigir_rol(['administrador']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!verificar_csrf($_POST['csrf'] ?? '')) $error = 'Solicitud no válida.';
  else {
    $accion = $_POST['accion'] ?? '';
    $id = (int)($_POST['id'] ?? 0);
    if ($accion === 'crear') {
      $titulo = trim($_POST['titulo'] ?? '');
      $desc = trim($_POST['descripcion'] ?? '');
      $seg = trim($_POST['segmento'] ?? '');
      $preguntas = array_filter(array_map('trim', $_POST['preguntas'] ?? []));
      $tipo = $_POST['tipo'] ?? 'opciones';
      if ($titulo === '' || $seg === '' || !$preguntas) $error = 'Complete título, segmento y al menos una pregunta.';
      else {
        $pdo->beginTransaction();
        try {
          $pdo->prepare('INSERT INTO encuestas(titulo,descripcion,segmento) VALUES(?,?,?)')->execute([$titulo, $desc, $seg]);
          $eid = (int)$pdo->lastInsertId();
          $ord = 1;
          $stmt = $pdo->prepare('INSERT INTO preguntas_encuesta(encuesta_id,pregunta,tipo,orden) VALUES(?,?,?,?)');
          foreach ($preguntas as $p) {
            $stmt->execute([$eid, $p, $tipo, $ord++]);
          }
          $pdo->commit();
          guardar_auditoria($pdo, $_SESSION['usuario_id'], 'CREAR', 'ENCUESTAS', 'Creó encuesta: ' . $titulo);
          $msg = 'Encuesta creada correctamente.';
        } catch (Throwable $e) {
          $pdo->rollBack();
          $error = 'No se pudo crear la encuesta.';
        }
      }
    } elseif ($accion === 'estado') {
      $estado = (int)($_POST['estado'] ?? 0);
      $pdo->prepare('UPDATE encuestas SET activa=? WHERE id=?')->execute([$estado, $id]);
      guardar_auditoria($pdo, $_SESSION['usuario_id'], $estado ? 'ACTIVAR' : 'DESACTIVAR', 'ENCUESTAS', 'Encuesta ID ' . $id);
      $msg = 'Estado actualizado.';
    }
  }
}
$encuestas = $pdo->query("SELECT e.*, (SELECT COUNT(*) FROM preguntas_encuesta p WHERE p.encuesta_id=e.id) preguntas, (SELECT COUNT(*) FROM respuestas_encuesta r WHERE r.encuesta_id=e.id) respuestas FROM encuestas e ORDER BY e.id DESC")->fetchAll();
?>
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h1 class="h2">Encuestas</h1>
    <p class="text-muted mb-0">Cree encuestas y segméntelas según las necesidades del hospital.</p>
  </div>
</div>
<?php if ($msg): ?><div class="alert alert-success"><?= e($msg) ?></div><?php endif; ?><?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
<div class="card border-0 shadow-sm mb-4">
  <div class="card-body p-4 d-flex flex-column">
    <h2 class="h5">Nueva encuesta</h2>
    <form method="post" id="encuestaForm" class="row g-3"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><input type="hidden" name="accion" value="crear">
      <div class="col-md-6"><label class="form-label">Título *</label><input class="form-control" name="titulo" required></div>
      <div class="col-md-6"><label class="form-label">Segmento *</label><input class="form-control" name="segmento" placeholder="General, Trasplante, FNR..." required></div>
      <div class="col-12"><label class="form-label">Descripción</label><textarea class="form-control" name="descripcion" rows="2"></textarea></div>
      <div class="col-md-4"><label class="form-label">Tipo de preguntas</label><select class="form-select" name="tipo">
          <option value="opciones">Opciones</option>
          <option value="si_no">Sí / No</option>
          <option value="texto">Texto</option>
        </select></div>
      <div class="col-12"><label class="form-label">Preguntas *</label>
        <div id="preguntas"></div><button type="button" class="btn btn-outline-primary mt-2" onclick="agregarPregunta()"><i class="bi bi-plus-circle me-1"></i>Agregar pregunta</button>
      </div>
      <div class="col-12"><button class="btn btn-primary">Crear encuesta</button></div>
    </form>
  </div>
</div>
<div class="row g-4"><?php foreach ($encuestas as $e1): ?><div class="col-md-6 col-xl-4">
      <div class="card h-100 border-0 shadow-sm admin-card">
        <div class="card-body p-4 d-flex flex-column"><span class="badge text-bg-info"><?= e($e1['segmento']) ?></span>
          <h2 class="h5 mt-3"><?= e($e1['titulo']) ?></h2>
          <p class="text-muted"><?= e($e1['descripcion']) ?></p>
          <p class="mb-1">Preguntas: <strong><?= $e1['preguntas'] ?></strong></p>
          <p>Respuestas: <strong><?= $e1['respuestas'] ?></strong></p>
          <div class="d-flex gap-2 mt-auto pt-3"><a class="btn btn-primary btn-sm" href="<?= url('admin/resultados_encuesta.php?id=' . $e1['id']) ?>">Resultados</a>
            <form method="post"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><input type="hidden" name="accion" value="estado"><input type="hidden" name="id" value="<?= $e1['id'] ?>"><input type="hidden" name="estado" value="<?= $e1['activa'] ? 0 : 1 ?>"><button class="btn btn-sm <?= $e1['activa'] ? 'btn-outline-danger' : 'btn-outline-success' ?>"><?= $e1['activa'] ? 'Desactivar' : 'Activar' ?></button></form>
          </div>
        </div>
      </div>
    </div><?php endforeach; ?></div>
<script>
  let contador = 0;

  function agregarPregunta() {
    contador++;
    const div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = '<span class="input-group-text">' + contador + '</span><input name="preguntas[]" class="form-control" required placeholder="Escriba la pregunta"><button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">Quitar</button>';
    document.getElementById('preguntas').appendChild(div);
  }
  agregarPregunta();
</script>
<?php require_once __DIR__ . '/_footer.php'; ?>