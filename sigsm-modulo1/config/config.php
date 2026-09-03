<?php
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'httponly' => true,
        'samesite' => 'Lax',
        'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
    ]);
    session_start();
}
$DOCUMENT_ROOT = isset($_SERVER['DOCUMENT_ROOT']) ? realpath($_SERVER['DOCUMENT_ROOT']) : false;
$PROJECT_ROOT = realpath(__DIR__ . '/..');

if ($DOCUMENT_ROOT && $PROJECT_ROOT) {
    $base = str_replace('\\', '/', str_replace($DOCUMENT_ROOT, '', $PROJECT_ROOT));
    $base_url = $base === '' ? '' : $base;
} else {
    $base_url = '';
}

function url($path = '')
{
    global $base_url;
    return rtrim($base_url, '/') . '/' . ltrim($path, '/');
}

$URL_PUBLICA = 'https://climate-assess-financing-hopkins.trycloudflare.com/';

function url_publica($path = '')
{
    global $URL_PUBLICA, $base_url;

    if ($URL_PUBLICA !== '') {
        return rtrim($URL_PUBLICA, '/') . '/' . ltrim($path, '/');
    }

    $es_https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
    $protocolo = $es_https ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';

    return $protocolo . '://' . $host . '/' . ltrim($base_url, '/') . '/' . ltrim($path, '/');
}
