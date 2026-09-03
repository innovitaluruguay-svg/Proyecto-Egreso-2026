<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/functions.php';
$mensaje = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf']) || !verificar_csrf($_POST['csrf'])) $error = 'Solicitud no válida.';
    else {
        $nombre = trim($_POST['nombre'] ?? '');
        $usuario = trim($_POST['usuario'] ?? '');
        $pass = $_POST['password'] ?? '';
        if ($nombre === '' || $usuario === '' || strlen($pass) < 6) $error = 'Complete los campos. La contraseña debe tener al menos 6 caracteres.';
        else {
            try {
                $pdo->prepare('INSERT INTO usuarios(nombre,usuario,password,rol) VALUES(?,?,?,\'administrador\')')->execute([$nombre, $usuario, password_hash($pass, PASSWORD_DEFAULT)]);
                $mensaje = 'Administrador creado. Borre este archivo antes de publicar el sistema.';
            } catch (PDOException $e) {
                $error = 'No se pudo crear el usuario; puede que ya exista.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <main class="container py-5" style="max-width:650px">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h1 class="h3">Crear administrador inicial</h1>
                <p class="text-muted">Utilice esta pantalla una sola vez.</p><?php if ($mensaje): ?><div class="alert alert-success"><?= e($mensaje) ?></div><?php endif; ?><?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?><form method="post"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                    <div class="mb-3"><label class="form-label">Nombre completo</label><input class="form-control" name="nombre" required></div>
                    <div class="mb-3"><label class="form-label">Usuario</label><input class="form-control" name="usuario" required></div>
                    <div class="mb-4"><label class="form-label">Contraseña</label><input class="form-control" type="password" name="password" minlength="6" required></div><button class="btn btn-primary">Crear</button>
                </form>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>