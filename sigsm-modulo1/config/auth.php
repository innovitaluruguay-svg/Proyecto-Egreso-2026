<?php
require_once __DIR__ . '/config.php';


function usuario_logueado()
{
    return isset($_SESSION['usuario_id']);
}

function iniciar_sesion($usuario)
{
    session_regenerate_id(true);
    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['nombre'] = $usuario['nombre'];
    $_SESSION['usuario'] = $usuario['usuario'];
    $_SESSION['rol'] = $usuario['rol'];
}

function exigir_login()
{
    if (!usuario_logueado()) {
        header('Location: ' . url('admin/login.php'));
        exit;
    }
}

function exigir_rol($roles)
{
    exigir_login();
    if (!in_array($_SESSION['rol'], $roles, true)) {
        http_response_code(403);
        exit('No tiene permisos para realizar esta acción.');
    }
}

function cerrar_sesion()
{
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }
    session_destroy();
}
