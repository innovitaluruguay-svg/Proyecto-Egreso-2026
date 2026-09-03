<?php
$titulo_pagina = 'Usuarios';
require_once __DIR__ . '/_header.php';
require_once __DIR__ . '/../config/functions.php';
exigir_rol(['administrador']);
$msg = '';
$error = '';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verificar_csrf($_POST['csrf'] ?? '')) $error = 'Solicitud no válida.';
    else {
        $accion = $_POST['accion'] ?? '';
        if ($accion === 'crear') {
            $nombre = trim($_POST['nombre'] ?? '');
            $usuario = trim($_POST['usuario'] ?? '');
            $pass = $_POST['password'] ?? '';
            $rol = $_POST['rol'] ?? 'funcionario';
            if ($nombre === '' || $usuario === '' || strlen($pass) < 6 || !in_array($rol, ['administrador', 'funcionario'], true)) $error = 'Complete los datos. La contraseña debe tener al menos 6 caracteres.';
            else {
                try {
                    $hash = password_hash($pass, PASSWORD_DEFAULT);
                    $pdo->prepare('INSERT INTO usuarios(nombre,usuario,password,rol) VALUES(?,?,?,?)')->execute([$nombre, $usuario, $hash, $rol]);
                    guardar_auditoria($pdo, $_SESSION['usuario_id'], 'CREAR', 'USUARIOS', 'Creó usuario: ' . $usuario);
                    $msg = 'Usuario creado.';
                } catch (PDOException $e) {
                    $error = 'Ese nombre de usuario ya existe.';
                }
            }
        } elseif ($accion === 'estado') {
            $id = (int)($_POST['id'] ?? 0);
            $estado = (int)($_POST['estado'] ?? 0);
            if ($id === $_SESSION['usuario_id'] && $estado === 0) $error = 'No puede desactivar su propio usuario.';
            else {
                $pdo->prepare('UPDATE usuarios SET activo=? WHERE id=?')->execute([$estado, $id]);
                guardar_auditoria($pdo, $_SESSION['usuario_id'], $estado ? 'ACTIVAR' : 'DESACTIVAR', 'USUARIOS', 'Usuario ID ' . $id);
                $msg = 'Estado actualizado.';
            }
        }
    }
}
$users = $pdo->query('SELECT id,nombre,usuario,rol,activo,fecha_creacion FROM usuarios ORDER BY nombre')->fetchAll();
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2">Usuarios</h1>
        <p class="text-muted mb-0">Cree usuarios administrativos y funcionarios.</p>
    </div>
</div>
<?php if ($msg): ?><div class="alert alert-success"><?= e($msg) ?></div><?php endif; ?><?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <h2 class="h5">Nuevo usuario</h2>
        <form method="post" class="row g-3"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><input type="hidden" name="accion" value="crear">
            <div class="col-md-3"><label class="form-label">Nombre</label><input class="form-control" name="nombre" required></div>
            <div class="col-md-3"><label class="form-label">Usuario</label><input class="form-control" name="usuario" required></div>
            <div class="col-md-3"><label class="form-label">Contraseña</label><input type="password" class="form-control" name="password" minlength="6" required></div>
            <div class="col-md-3"><label class="form-label">Rol</label><select class="form-select" name="rol">
                    <option value="funcionario">Funcionario</option>
                    <option value="administrador">Administrador</option>
                </select></div>
            <div class="col-12"><button class="btn btn-primary">Crear usuario</button></div>
        </form>
    </div>
</div>
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nombre</th>
                    <th>Usuario</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody><?php foreach ($users as $u): ?><tr>
                        <td><?= e($u['nombre']) ?></td>
                        <td><?= e($u['usuario']) ?></td>
                        <td><?= e($u['rol']) ?></td>
                        <td><?= $u['activo'] ? '<span class="badge text-bg-success">Activo</span>' : '<span class="badge text-bg-secondary">Inactivo</span>' ?></td>
                        <td class="text-end">
                            <form method="post"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><input type="hidden" name="accion" value="estado"><input type="hidden" name="id" value="<?= $u['id'] ?>"><input type="hidden" name="estado" value="<?= $u['activo'] ? 0 : 1 ?>"><button class="btn btn-sm <?= $u['activo'] ? 'btn-outline-danger' : 'btn-outline-success' ?>"><?= $u['activo'] ? 'Desactivar' : 'Activar' ?></button></form>
                        </td>
                    </tr><?php endforeach; ?></tbody>
        </table>
    </div>
</div>
<?php require_once __DIR__ . '/_footer.php'; ?>