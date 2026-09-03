<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/functions.php';
require_once __DIR__ . '/../config/database.php';

if (usuario_logueado()) {
    header('Location: ' . url('admin/dashboard.php'));
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!verificar_csrf($_POST['csrf'] ?? '')) {
        $error = 'Solicitud no válida. Actualice la página.';
    } else {

        $usuario = trim($_POST['usuario'] ?? '');
        $password = $_POST['password'] ?? '';

        $stmt = $pdo->prepare(
            'SELECT * FROM usuarios WHERE usuario=? AND activo=1 LIMIT 1'
        );

        $stmt->execute([$usuario]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password'])) {

            iniciar_sesion($admin);

            guardar_auditoria(
                $pdo,
                $admin['id'],
                'LOGIN',
                'AUTH',
                'Inicio de sesión correcto'
            );

            if ($admin['rol']  ===  'funcionario') {
                header('Location: ' . url('admin/documentos.php'));
            } else {
                header('Location: ' . url('admin/dashboard.php'));
            }

            exit;
        }

        $error = 'Usuario o contraseña incorrectos';
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ingreso administrativo | Hospital de Clínicas</title>


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

<body class="login-body">

    <div class="container min-vh-100 d-flex align-items-center justify-content-center">

        <div class="card shadow border-0 login-card">

            <div class="card-body p-4 p-md-5">


                <div class="text-center mb-4">

                    <img
                        src="<?= url('public/assets/img/logo_hospitaldeclinicas.png') ?>"
                        alt="Hospital de Clínicas"
                        class="logo-login mb-3">

                    <h1 class="h3 mt-2">
                        Panel administrativo
                    </h1>

                </div>


                <?php if ($error): ?>

                    <div class="alert alert-danger">
                        <?= e($error) ?>
                    </div>

                <?php endif; ?>

                <form method="post">

                    <input
                        type="hidden"
                        name="csrf"
                        value="<?= e(csrf_token()) ?>">

                    <div class="mb-3">

                        <label
                            class="form-label"
                            for="usuario">
                            Usuario
                        </label>

                        <input
                            type="text"
                            id="usuario"
                            name="usuario"
                            class="form-control form-control-lg"
                            required
                            autocomplete="username">

                    </div>
                    <div class="mb-4">

                        <label
                            class="form-label"
                            for="password">
                            Contraseña
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control form-control-lg"
                            required
                            autocomplete="current-password">

                    </div>

                    <button
                        type="submit"
                        class="btn btn-primary btn-lg w-100">

                        <i class="bi bi-box-arrow-in-right me-2"></i>

                        Ingresar

                    </button>

                </form>

            </div>

        </div>

    </div>

</body>

</html>