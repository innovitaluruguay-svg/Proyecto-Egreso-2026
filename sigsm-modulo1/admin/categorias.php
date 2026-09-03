<?php
$titulo_pagina = 'Categorías';
require_once __DIR__ . '/_header.php';
require_once __DIR__ . '/../config/functions.php';
$msg = '';
$error = '';
exigir_rol(['administrador']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verificar_csrf($_POST['csrf'] ?? '')) $error = 'Solicitud no válida.';
    else {
        $accion = $_POST['accion'] ?? '';
        $id = (int)($_POST['id'] ?? 0);
        if ($accion === 'crear') {
            $nombre = trim($_POST['nombre'] ?? '');
            $desc = trim($_POST['descripcion'] ?? '');
            if ($nombre === '') $error = 'El nombre es obligatorio.';
            else {
                try {
                    $pdo->prepare('INSERT INTO categorias(nombre,descripcion) VALUES(?,?)')->execute([$nombre, $desc]);
                    guardar_auditoria($pdo, $_SESSION['usuario_id'], 'CREAR', 'CATEGORIAS', 'Creó categoría: ' . $nombre);
                    $msg = 'Categoría creada.';
                } catch (PDOException $e) {
                    $error = 'La categoría ya existe o no se pudo crear.';
                }
            }
        } elseif (in_array($accion, ['activar', 'desactivar'], true)) {
            $estado = $accion === 'activar' ? 1 : 0;
            $pdo->prepare('UPDATE categorias SET activo=? WHERE id=?')->execute([$estado, $id]);
            guardar_auditoria($pdo, $_SESSION['usuario_id'], strtoupper($accion), 'CATEGORIAS', 'Categoría ID ' . $id);
            $msg = 'Estado actualizado.';
        }
    }
}
$cats = $pdo->query('SELECT * FROM categorias ORDER BY nombre')->fetchAll();
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2">Categorías</h1>
        <p class="text-muted mb-0">Organice los documentos según el área o tipo de información.</p>
    </div>
</div>
<?php if ($msg): ?><div class="alert alert-success"><?= e($msg) ?></div><?php endif; ?><?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="post" class="row g-3"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><input type="hidden" name="accion" value="crear">
            <div class="col-md-5"><label class="form-label">Nombre</label><input class="form-control" name="nombre" required></div>
            <div class="col-md-5"><label class="form-label">Descripción</label><input class="form-control" name="descripcion"></div>
            <div class="col-md-2 d-flex align-items-end"><button class="btn btn-primary w-100">Crear</button></div>
        </form>
    </div>
</div>
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody><?php foreach ($cats as $c): ?><tr>
                        <td><?= e($c['nombre']) ?></td>
                        <td><?= e($c['descripcion']) ?></td>
                        <td><?= $c['activo'] ? '<span class="badge text-bg-success">Activa</span>' : '<span class="badge text-bg-secondary">Inactiva</span>' ?></td>
                        <td class="text-end">
                            <form method="post"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><input type="hidden" name="accion" value="<?= $c['activo'] ? 'desactivar' : 'activar' ?>"><input type="hidden" name="id" value="<?= $c['id'] ?>"><button class="btn btn-sm <?= $c['activo'] ? 'btn-outline-danger' : 'btn-outline-success' ?>"><?= $c['activo'] ? 'Desactivar' : 'Activar' ?></button></form>
                        </td>
                    </tr><?php endforeach; ?></tbody>
        </table>
    </div>
</div>
<?php require_once __DIR__ . '/_footer.php'; ?>