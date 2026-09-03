<?php
require_once __DIR__ . '/config.php';
$host = 'localhost';
$db   = 'hospital_clinicas';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $e) {
    error_log('Error de conexión SIGSM: ' . $e->getMessage());
    http_response_code(500);
    exit('No se pudo conectar con la base de datos. Revise la configuración del sistema.');
}
