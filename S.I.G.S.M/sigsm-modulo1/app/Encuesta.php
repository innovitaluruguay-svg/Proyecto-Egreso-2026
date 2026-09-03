<?php
class Encuesta
{
    public static function activas($pdo)
    {
        $stmt = $pdo->query(
            'SELECT id,titulo,descripcion,segmento
             FROM encuestas
             WHERE activa=1
             ORDER BY titulo'
        );
        return $stmt->fetchAll();
    }
}
