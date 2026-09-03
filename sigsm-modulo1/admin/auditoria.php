<?php
$titulo_pagina = 'Auditoría';
require_once __DIR__ . '/_header.php';
exigir_rol(['administrador']);
$logs = $pdo->query('SELECT a.*,u.nombre usuario FROM auditoria a LEFT JOIN usuarios u ON u.id=a.usuario_id ORDER BY a.fecha DESC LIMIT 200')->fetchAll();
?>
<div class="mb-4">
    <h1 class="h2">Auditoría</h1>
    <p class="text-muted">Últimas acciones realizadas en el sistema.</p>
</div>
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Fecha</th>
                    <th>Usuario</th>
                    <th>Acción</th>
                    <th>Módulo</th>
                    <th>Descripción</th>
                    <th>IP</th>
                </tr>
            </thead>
            <tbody><?php foreach ($logs as $l): ?><tr>
                        <td><?= e($l['fecha']) ?></td>
                        <td><?= e($l['usuario'] ?? 'Sistema') ?></td>
                        <td><span class="badge text-bg-light border"><?= e($l['accion']) ?></span></td>
                        <td><?= e($l['modulo']) ?></td>
                        <td><?= e($l['descripcion']) ?></td>
                        <td><?= e($l['ip']) ?></td>
                    </tr><?php endforeach; ?></tbody>
        </table>
    </div>
</div>
<?php require_once __DIR__ . '/_footer.php'; ?>