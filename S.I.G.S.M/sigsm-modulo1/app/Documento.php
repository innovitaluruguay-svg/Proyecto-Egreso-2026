<?php
class Documento
{
    public static function obtenerActivos($pdo)
    {
        $stmt = $pdo->query(
            'SELECT d.id,d.titulo,d.descripcion,c.nombre categoria
             FROM documentos d
             JOIN categorias c ON c.id=d.categoria_id
             WHERE d.activo=1 AND c.activo=1
             ORDER BY c.nombre,d.titulo'
        );
        return $stmt->fetchAll();
    }

    public static function obtenerPorId($pdo, $id)
    {
        $stmt = $pdo->prepare(
            'SELECT d.*, c.nombre categoria
             FROM documentos d
             JOIN categorias c ON c.id=d.categoria_id
             WHERE d.id=? AND d.activo=1 AND c.activo=1'
        );
        $stmt->execute([(int)$id]);
        return $stmt->fetch();
    }
}
