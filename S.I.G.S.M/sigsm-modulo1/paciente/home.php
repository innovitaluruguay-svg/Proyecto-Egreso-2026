<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/functions.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/Documento.php';
require_once __DIR__ . '/../app/Encuesta.php';

$docs = Documento::obtenerActivos($pdo);
$encs = Encuesta::activas($pdo);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información para pacientes | Hospital de Clínicas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= url('public/assets/css/paciente.css') ?>" rel="stylesheet">

</head>

<body>
        <nav class="navbar navbar-expand-lg navbar-light paciente-navbar shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold" href="<?= url('paciente/home.php') ?>">
                    <img src="<?= url('public/assets/img/logo_hospitaldeclinicas.png') ?>" alt="Hospital de Clínicas" class="brand-logo">
                    <span class="brand-label">Portal de pacientes</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="menu">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item"><a class="nav-link active" href="#inicio"><i class="bi bi-house"></i>Inicio</a></li>
                        <li class="nav-item"><a class="nav-link" href="#documentos"><i class="bi bi-file-earmark-text"></i>Documentos</a></li>
                        <li class="nav-item"><a class="nav-link" href="#encuestas"><i class="bi bi-clipboard2-pulse"></i>Encuestas</a></li>
                        <li class="nav-item"><a class="nav-link" href="#ayuda"><i class="bi bi-question-circle"></i>Ayuda</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    <main id="inicio" class="container my-4">
        <section class="hero shadow-sm mb-4">
            <div class="p-4 p-md-5"><span class="text-primary fw-bold">Portal de información para pacientes</span>
                <h1 class="display-6 mt-2">Información para pacientes</h1>
                <p class="lead mb-0">Consulte documentación e indicaciones proporcionadas por el Hospital de Clínicas.</p>
            </div>
        </section>
        <section class="search-box shadow-sm mb-5">
            <h2 class="h3">Buscar información</h2>
            <form id="formBusqueda">
                <div class="row g-2">
                    <div class="col-md-9"><input id="busqueda" class="form-control form-control-lg" placeholder="Ejemplo: ecocardiograma"></div>
                    <div class="col-md-3"><button class="btn btn-primary btn-lg w-100">Buscar</button></div>
                </div>
            </form>
            <div id="resultadoBusqueda" class="mt-3"></div>
        </section>
        <section id="documentos" class="mb-5">
            <h2 class="h3">Información disponible</h2>
            <p class="text-muted">Seleccione un documento para consultarlo.</p>
            <div class="row g-3"><?php foreach ($docs as $d): ?><div class="col-12">
                        <article class="document-card shadow-sm p-3">
                            <div class="row align-items-center g-3">
                                <div class="col-md">
                                    <div class="d-flex"><i class="bi bi-file-earmark-text document-icon me-3"></i>
                                        <div><span class="badge text-bg-light border mb-2"><?= e($d['categoria']) ?></span>
                                            <h3 class="h5 mb-1"><?= e($d['titulo']) ?></h3>
                                            <p class="mb-0 text-muted"><?= e($d['descripcion']) ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-auto"><a class="btn btn-primary w-100 mt-auto" href="<?= url('paciente/documento.php?id=' . $d['id']) ?>">Ver documento</a></div>
                            </div>
                        </article>
                    </div><?php endforeach; ?><?php if (!$docs): ?><div class="col-12">
                        <div class="alert alert-info">No hay documentos publicados.</div>
                    </div><?php endif; ?></div>
        </section>
        <section id="encuestas" class="mb-5">
            <h2 class="h3">Encuestas de satisfacción</h2>
            <p class="text-muted">Las encuestas son anónimas y no requieren iniciar sesión.</p>
            <div class="row g-3"><?php foreach ($encs as $e): ?><div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-4 d-flex flex-column"><span class="badge text-bg-info"><?= e($e['segmento']) ?></span>
                                <h3 class="h5 mt-3"><?= e($e['titulo']) ?></h3>
                                <p><?= e($e['descripcion']) ?></p><a class="btn btn-primary w-100 mt-auto" href="<?= url('paciente/encuesta.php?id=' . $e['id']) ?>">Responder encuesta</a>
                            </div>
                        </div>
                    </div><?php endforeach; ?></div>
        </section>
        <section id="ayuda" class="help-box shadow-sm p-4 mb-5">
            <h2 class="h3">¿Necesita ayuda?</h2>
            <p class="mb-0">Si tiene dificultades para utilizar este portal, solicite asistencia al personal del Hospital de Clínicas.</p>
        </section>
    </main>
    <footer class="border-top py-4">
        <div class="container text-center"><strong>Hospital de Clínicas</strong>
            <p class="text-muted mb-0">Portal de información para pacientes</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const docs = <?= json_encode(array_map(fn($d) => ['titulo' => $d['titulo'], 'descripcion' => $d['descripcion'], 'url' => url('paciente/documento.php?id=' . $d['id'])], $docs), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
        document.getElementById('formBusqueda').addEventListener('submit', e => {
            e.preventDefault();
            const q = document.getElementById('busqueda').value.toLowerCase().trim();
            const out = document.getElementById('resultadoBusqueda');
            if (!q) {
                out.innerHTML = '<div class="alert alert-warning">Escriba qué información desea buscar.</div>';
                return;
            }
            const r = docs.filter(d => d.titulo.toLowerCase().includes(q) || (d.descripcion || '').toLowerCase().includes(q));
            if (!r.length) {
                out.innerHTML = '<div class="alert alert-secondary">No encontramos documentos relacionados.</div>';
                return;
            }
            out.innerHTML = '<h3 class="h5 mt-3">Resultados</h3>' + r.map(d => `<div class="card mb-2"><div class="card-body"><strong>${d.titulo}</strong><p class="mb-2">${d.descripcion||''}</p><a class="btn btn-primary btn-sm" href="${d.url}">Ver</a></div></div>`).join('');
        });
    </script>
</body>

</html>
