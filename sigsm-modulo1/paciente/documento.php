<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/functions.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/Documento.php';

$id = (int)($_GET['id'] ?? 0);

$doc = Documento::obtenerPorId($pdo, $id);

if (!$doc) {
    exit('Documento no disponible.');
}
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?= e($doc['titulo']) ?> | Hospital de Clínicas
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet">

    <link
        href="<?= url('public/assets/css/paciente.css') ?>?v=3"
        rel="stylesheet">

</head>

<body>



    <nav class="navbar navbar-expand-lg navbar-light paciente-navbar shadow-sm">

        <div class="container">

            <a
                class="navbar-brand fw-bold"
                href="<?= url('paciente/home.php') ?>">

                <img
                    src="<?= url('public/assets/img/logo_hospitaldeclinicas.png') ?>"
                    alt="Hospital de Clínicas"
                    class="brand-logo">

                <span class="brand-label">
                    Portal de pacientes
                </span>

            </a>


            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#menu">

                <span class="navbar-toggler-icon"></span>

            </button>


            <div
                class="collapse navbar-collapse"
                id="menu">

                <ul class="navbar-nav mx-auto">

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="<?= url('paciente/home.php#inicio') ?>">

                            <i class="bi bi-house"></i>
                            Inicio

                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            class="nav-link active"
                            href="<?= url('paciente/home.php#documentos') ?>">

                            <i class="bi bi-file-earmark-text"></i>
                            Documentos

                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="<?= url('paciente/home.php#encuestas') ?>">

                            <i class="bi bi-clipboard2-pulse"></i>
                            Encuestas

                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="<?= url('paciente/home.php#ayuda') ?>">

                            <i class="bi bi-question-circle"></i>
                            Ayuda

                        </a>

                    </li>

                </ul>


                <span class="badge badge-qr px-3 py-2">

                    <i class="bi bi-qr-code me-1"></i>
                    Acceso por QR

                </span>

            </div>

        </div>

    </nav>

    <main class="container my-4">

        <div class="d-flex flex-wrap gap-2 mb-3">

            <a
                href="<?= url('paciente/home.php#documentos') ?>"
                class="btn btn-outline-primary">

                <i class="bi bi-arrow-left me-1"></i>
                Volver a documentos

            </a>

            <a
                href="<?= url('paciente/ver_pdf.php?id=' . $doc['id']) ?>"
                target="_blank"
                class="btn btn-primary">

                <i class="bi bi-box-arrow-up-right me-1"></i>
                Abrir PDF

            </a>

            <a
                href="<?= url('paciente/ver_pdf.php?id=' . $doc['id']) ?>"
                download
                class="btn btn-success">

                <i class="bi bi-download me-1"></i>
                Descargar PDF

            </a>

        </div>


        <section class="document-viewer shadow-sm">


            <section class="document-viewer shadow-sm">

                <div class="p-4">

                    <h1 class="h3 mb-2">
                        <?= e($doc['titulo']) ?>
                    </h1>

                    <p class="text-muted mb-0">
                        <?= e($doc['descripcion']) ?>
                    </p>

                </div>


                <!-- Apunta directamente a ver_pdf.php pasándole el ID -->
                <iframe
                    src="<?= url('paciente/ver_pdf.php?id=' . $doc['id']) ?>"
                    class="pdf-viewer"
                    title="<?= e($doc['titulo']) ?>">
                </iframe>

            </section>

    </main>


    <footer class="border-top py-4">

        <div class="container text-center">

            <strong>Hospital de Clínicas</strong>

            <p class="text-muted mb-0">
                Portal de información para pacientes
            </p>

        </div>

    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>