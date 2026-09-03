<?php
function e($valor)
{
    return htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8');
}

function csrf_token()
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verificar_csrf($token)
{
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], (string)$token);
}

function guardar_auditoria($pdo, $usuario_id, $accion, $modulo, $descripcion = '')
{
    $stmt = $pdo->prepare(
        'INSERT INTO auditoria (usuario_id, accion, modulo, descripcion, ip) VALUES (?, ?, ?, ?, ?)'
    );
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'desconocida';
    $stmt->execute([$usuario_id, $accion, $modulo, $descripcion, $ip]);
}

function pdf_valido($archivo, $max_mb = 10)
{
    if (!$archivo || !isset($archivo['error'])) return false;
    if ($archivo['error'] !== UPLOAD_ERR_OK) return false;
    if (($archivo['size'] ?? 0) > $max_mb * 1024 * 1024) return false;
    if (strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION)) !== 'pdf') return false;
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($archivo['tmp_name']);
    return $mime === 'application/pdf';
}
