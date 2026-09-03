<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/functions.php';
require_once __DIR__ . '/../config/database.php';

exigir_login();
?>

<!DOCTYPE html>
<html lang="es">

<head>

  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>
    <?= e($titulo_pagina ?? 'Panel administrativo') ?> | Hospital de Clínicas
  </title>

  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet">

  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
    rel="stylesheet">

  <link
    href="<?= url('public/assets/css/admin.css') ?>"
    rel="stylesheet">

</head>

<body>

  <nav class="navbar navbar-expand-lg admin-navbar">

    <div class="container">

      <a
        class="navbar-brand admin-brand d-flex align-items-center"
        href="<?= url('admin/dashboard.php') ?>">

        <img
          src="<?= url('public/assets/img/logo_hospitaldeclinicas.png') ?>"
          alt="Hospital de Clínicas"
          class="logo-navbar">

        <span class="panel-titulo">
          Panel administrativo
        </span>

      </a>

      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#menuAdmin"
        aria-controls="menuAdmin"
        aria-expanded="false"
        aria-label="Abrir menú">

        <span class="navbar-toggler-icon"></span>

      </button>







      <?php if (($_SESSION['rol'] ?? '') === 'administrador'): ?>


        <div
          class="collapse navbar-collapse"
          id="menuAdmin">

          <ul class="navbar-nav me-auto mb-2 mb-lg-0">

            <li class="nav-item">
              <a
                class="nav-link admin-link"
                href="<?= url('admin/documentos.php') ?>">
                <i class="bi bi-file-earmark-text me-1"></i>
                Documentos
              </a>
            </li>

            <li class="nav-item">
              <a
                class="nav-link admin-link"
                href="<?= url('admin/encuestas.php') ?>">
                <i class="bi bi-bar-chart-line me-1"></i>
                Encuestas
              </a>
            </li>

            <li class="nav-item">
              <a
                class="nav-link admin-link"
                href="<?= url('admin/categorias.php') ?>">
                <i class="bi bi-folder me-1"></i>
                Categorías
              </a>
            </li>


            <li class="nav-item">
              <a
                class="nav-link admin-link"
                href="<?= url('admin/usuarios.php') ?>">
                <i class="bi bi-people me-1"></i>
                Usuarios
              </a>
            </li>


            <li class="nav-item">
              <a
                class="nav-link admin-link"
                href="<?= url('admin/auditoria.php') ?>">
                <i class="bi bi-shield-check me-1"></i>
                Auditoría
              </a>
            </li>

          <?php endif; ?>

          </ul>

          <div class="d-flex align-items-center gap-3 admin-user">

            <span class="admin-user-text">

              <i class="bi bi-person-circle me-1"></i>

              <?= e($_SESSION['nombre']) ?>

              <span class="rol-text">
                (<?= e($_SESSION['rol']) ?>)
              </span>

            </span>


            <a
              href="<?= url('admin/logout.php') ?>"
              class="btn btn-sm btn-outline-primary">
              <i class="bi bi-box-arrow-right me-1"></i>
              Salir
            </a>

          </div>

        </div>

    </div>

  </nav>

  <main class="container py-4 admin-main">