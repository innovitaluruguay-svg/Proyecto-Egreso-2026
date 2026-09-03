<?php
$titulo_pagina = 'Resultados';
require_once __DIR__ . '/_header.php';
$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT * FROM encuestas WHERE id=?');
$stmt->execute([$id]);
$enc = $stmt->fetch();
if (!$enc) exit('Encuesta no encontrada.');
$pstmt = $pdo->prepare('SELECT * FROM preguntas_encuesta WHERE encuesta_id=? ORDER BY orden');
$pstmt->execute([$id]);
$preguntas = $pstmt->fetchAll();
?>
<div class="mb-4">
    <a href="<?= url('admin/encuestas.php') ?>" class="btn btn-outline-secondary mb-3">Volver</a>

    <div class="mt-2">
        <span class="badge text-bg-info"><?= e($enc['segmento']) ?></span>
    </div>

    <h1 class="h2 mt-3"><?= e($enc['titulo']) ?></h1>
</div>
<?php foreach ($preguntas as $p): $r = $pdo->prepare('SELECT respuesta,COUNT(*) cantidad FROM respuestas_encuesta WHERE encuesta_id=? AND pregunta_id=? GROUP BY respuesta ORDER BY cantidad DESC');
    $r->execute([$id, $p['id']]);
    $rows = $r->fetchAll();
    $total = array_sum(array_column($rows, 'cantidad')); ?>
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <h2 class="h5"><?= e($p['pregunta']) ?></h2>
            <p class="text-muted">Respuestas: <?= $total ?></p><?php foreach ($rows as $row): $por = $total ? round($row['cantidad'] * 100 / $total) : 0; ?><div class="mb-3">
                    <div class="d-flex justify-content-between"><span><?= e($row['respuesta']) ?></span><strong><?= $row['cantidad'] ?> (<?= $por ?>%)</strong></div>
                    <div class="progress" role="progressbar" aria-valuenow="<?= $por ?>" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="width:<?= $por ?>%"></div>
                    </div>
                </div><?php endforeach;
                                                                if (!$rows): ?><p class="text-muted mb-0">Todavía no hay respuestas.</p><?php endif; ?>
        </div>
    </div>
<?php endforeach;
require_once __DIR__ . '/_footer.php'; ?>