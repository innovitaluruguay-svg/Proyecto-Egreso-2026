<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/functions.php';
require_once __DIR__ . '/../config/database.php';
$id = (int)($_GET['id'] ?? $_POST['encuesta_id'] ?? 0);
$stmt = $pdo->prepare('SELECT * FROM encuestas WHERE id=? AND activa=1');
$stmt->execute([$id]);
$enc = $stmt->fetch();
if (!$enc) exit('Encuesta no disponible.');
$q = $pdo->prepare('SELECT * FROM preguntas_encuesta WHERE encuesta_id=? ORDER BY orden');
$q->execute([$id]);
$preguntas = $q->fetchAll();
$ok = false;
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($preguntas as $p) {
        $resp = trim($_POST['pregunta_' . $p['id']] ?? '');
        if ($resp === '') {
            $error = 'Complete todas las preguntas.';
            break;
        }
    }
    if ($error === '') {
        $pdo->beginTransaction();
        try {
            foreach ($preguntas as $p) {
                $resp = trim($_POST['pregunta_' . $p['id']]);
                $pdo->prepare('INSERT INTO respuestas_encuesta(encuesta_id,pregunta_id,respuesta) VALUES(?,?,?)')->execute([$id, $p['id'], $resp]);
            }
            $pdo->commit();
            $ok = true;
        } catch (Throwable $e) {
            $pdo->rollBack();
            $error = 'No se pudo guardar la encuesta.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($enc['titulo']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <nav class="navbar bg-white paciente-navbar">
        <div class="container">
            <a class="navbar-brand text-primary fw-semibold" href="<?= url('paciente/home.php') ?>">Hospital de Clínicas</a>
        </div>
    </nav>
    <main class="container py-4"><a class="btn btn-outline-secondary mb-4" href="<?= url('paciente/home.php#encuestas') ?>">Volver</a><?php if ($ok): ?><div class="alert alert-success">
                <h1 class="h4">Gracias por responder.</h1>
                <p class="mb-0">La respuesta fue registrada de forma anónima.</p>
            </div><?php else: ?><div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-md-5"><span class="badge text-bg-info"><?= e($enc['segmento']) ?></span>
                    <h1 class="h3 mt-3"><?= e($enc['titulo']) ?></h1>
                    <p class="text-muted"><?= e($enc['descripcion']) ?></p><?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?><div class="alert alert-primary">Esta encuesta es anónima.</div>
                    <form method="post"><input type="hidden" name="encuesta_id" value="<?= $id ?>"><?php foreach ($preguntas as $p): ?><div class="mb-4"><label class="form-label fw-semibold"><?= e($p['pregunta']) ?></label><?php if ($p['tipo'] === 'si_no'): ?><select class="form-select" name="pregunta_<?= $p['id'] ?>" required>
                                        <option value="">Seleccione...</option>
                                        <option>Sí</option>
                                        <option>No</option>
                                    </select><?php elseif ($p['tipo'] === 'texto'): ?><textarea class="form-control" name="pregunta_<?= $p['id'] ?>" rows="3" required></textarea><?php else: ?><select class="form-select" name="pregunta_<?= $p['id'] ?>" required>
                                        <option value="">Seleccione...</option>
                                        <option>Muy mala</option>
                                        <option>Mala</option>
                                        <option>Regular</option>
                                        <option>Buena</option>
                                        <option>Muy buena</option>
                                    </select><?php endif; ?></div><?php endforeach; ?><button class="btn btn-primary btn-lg">Enviar encuesta</button></form>
                </div>
            </div><?php endif; ?></main>
</body>

</html>