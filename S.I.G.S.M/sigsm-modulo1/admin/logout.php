<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/database.php';

if (usuario_logueado()) {
    try {
        guardar_auditoria($pdo, $_SESSION['usuario_id'], 'LOGOUT', 'AUTH', 'Cierre de sesión');
    } catch (Throwable $e) {
    }
}
cerrar_sesion();
header('Location: ' . url('admin/login.php'));
exit;
