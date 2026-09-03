<?php
$titulo_pagina = 'Panel administrativo';
require_once __DIR__ . '/_header.php';
$stats = [];
$stats['documentos'] = (int)$pdo->query('SELECT COUNT(*) FROM documentos WHERE activo=1')->fetchColumn();
$stats['categorias'] = (int)$pdo->query('SELECT COUNT(*) FROM categorias WHERE activo=1')->fetchColumn();
$stats['encuestas'] = (int)$pdo->query('SELECT COUNT(*) FROM encuestas WHERE activa=1')->fetchColumn();
$stats['respuestas'] = (int)$pdo->query('SELECT COUNT(*) FROM respuestas_encuesta')->fetchColumn();

?>


<div class="welcome-box p-5 shadow-sm mb-4">
    <h1 class="h2 mt-1">Bienvenido, <?= e($_SESSION['nombre']) ?></h1>
    <p class="text-muted mb-0">Gestione la documentación, categorías, encuestas y usuarios.</p>
</div>
<div class="row g-4 mb-4">
    <?php foreach ([['documentos', 'Documentos', 'bi-file-earmark-text', 'Gestionar documentos', 'admin/documentos.php', 'primary'], ['categorias', 'Categorías', 'bi-folder2-open', 'Organizar documentación', 'admin/categorias.php', 'outline-primary'], ['encuestas', 'Encuestas', 'bi-bar-chart-line', 'Gestionar y ver resultados', 'admin/encuestas.php', 'outline-primary']] as $c): ?>
        <div class="col-md-6 col-xl-4">
            <div class="card h-100 border-0 shadow-sm admin-card">
                <div class="card-body p-4"><i class="bi <?= $c[2] ?> icon-admin"></i>
                    <div class="display-6 fw-bold mt-2"><?= $stats[$c[0]] ?></div>
                    <h2 class="h5"><?= $c[1] ?></h2><a href="<?= url($c[4]) ?>" class="btn btn-<?= $c[5] ?>"><?= $c[3] ?></a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h2 class="h5">Resumen</h2>
                <p class="mb-2">Documentos publicados: <strong><?= $stats['documentos'] ?></strong></p>
                <p class="mb-2">Categorías activas: <strong><?= $stats['categorias'] ?></strong></p>
                <p class="mb-2">Encuestas activas: <strong><?= $stats['encuestas'] ?></strong></p>
                <p class="mb-0">Respuestas acumuladas: <strong><?= $stats['respuestas'] ?></strong></p>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <h2 class="h5">Acceso del paciente</h2><a class="btn btn-primary" target="_blank" href="<?= url('paciente/home.php') ?>">Abrir portal paciente</a>
            </div>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/_footer.php'; ?>