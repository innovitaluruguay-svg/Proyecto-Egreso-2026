USE hospital_clinicas;

SET @columna_existe = (
    SELECT COUNT(*)
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA='hospital_clinicas'
      AND TABLE_NAME='documentos'
      AND COLUMN_NAME='version_actual'
);

SET @sql = IF(
    @columna_existe > 0,
    'ALTER TABLE documentos DROP COLUMN version_actual',
    'SELECT 1'
);

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

DROP TABLE IF EXISTS documento_versiones;
