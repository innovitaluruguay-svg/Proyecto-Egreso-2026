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

$path = __DIR__ . '/../public/storage/documentos/' . $doc['archivo'];

if (!is_file($path)) {
    exit('Archivo no disponible.');
}

header('Content-Type: application/pdf');

header(
    'Content-Disposition: inline; filename="documento-' .
        $doc['id'] .
        '.pdf"'
);

header('X-Content-Type-Options: nosniff');

readfile($path);

exit;
