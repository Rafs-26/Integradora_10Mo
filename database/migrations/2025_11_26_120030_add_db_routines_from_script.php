<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared(<<<SQL
-- Vista vista_estadisticas_carreras
CREATE OR REPLACE VIEW vista_estadisticas_carreras AS
SELECT 
    c.id as carrera_id,
    c.nombre as carrera_nombre,
    c.codigo as carrera_codigo,
    COUNT(e.id) as total_estadias,
    COUNT(CASE WHEN e.status = 'finalizada' THEN 1 END) as estadias_finalizadas,
    COUNT(CASE WHEN e.status = 'en_proceso' THEN 1 END) as estadias_en_proceso,
    COUNT(CASE WHEN e.status = 'solicitud' THEN 1 END) as solicitudes_pendientes,
    ROUND((COUNT(CASE WHEN e.status = 'finalizada' THEN 1 END) * 100.0 / NULLIF(COUNT(e.id), 0)), 2) as porcentaje_finalizadas
FROM carreras c
LEFT JOIN estudiantes est ON c.id = est.carrera_id
LEFT JOIN estadias e ON est.id = e.estudiante_id
WHERE c.activa = TRUE
GROUP BY c.id, c.nombre, c.codigo;
SQL);

        DB::unprepared(<<<SQL
-- Procedimiento EstadisticasPorRol
DROP PROCEDURE IF EXISTS EstadisticasPorRol;
DELIMITER $$
CREATE PROCEDURE EstadisticasPorRol()
BEGIN
    SELECT 
        r.nombre as rol_nombre,
        r.slug as rol_slug,
        COUNT(u.id) as total_usuarios,
        COUNT(CASE WHEN u.status = 'activo' THEN 1 END) as usuarios_activos,
        COUNT(CASE WHEN u.status = 'inactivo' THEN 1 END) as usuarios_inactivos,
        COUNT(CASE WHEN u.status = 'suspendido' THEN 1 END) as usuarios_suspendidos,
        COUNT(CASE WHEN u.ultimo_acceso >= DATE_SUB(NOW(), INTERVAL 30 DAY) THEN 1 END) as activos_ultimo_mes
    FROM roles r
    LEFT JOIN users u ON r.id = u.rol_id
    WHERE r.activo = TRUE
    GROUP BY r.id, r.nombre, r.slug
    ORDER BY total_usuarios DESC;
END$$
DELIMITER ;
SQL);

        DB::unprepared(<<<SQL
-- Procedimiento EspacioOcupadoDocumentos
DROP PROCEDURE IF EXISTS EspacioOcupadoDocumentos;
DELIMITER $$
CREATE PROCEDURE EspacioOcupadoDocumentos()
BEGIN
    SELECT 
        COUNT(*) as total_documentos,
        ROUND(SUM(tamaño_archivo) / 1024 / 1024, 2) as espacio_total_mb,
        ROUND(AVG(tamaño_archivo) / 1024, 2) as tamaño_promedio_kb,
        tipo_documento,
        COUNT(*) as documentos_por_tipo,
        ROUND(SUM(tamaño_archivo) / 1024 / 1024, 2) as espacio_por_tipo_mb
    FROM documentos
    GROUP BY tipo_documento
    WITH ROLLUP;
END$$
DELIMITER ;
SQL);

        DB::unprepared(<<<SQL
-- Trigger validar_tamaño_documento
DROP TRIGGER IF EXISTS validar_tamaño_documento;
DELIMITER $$
CREATE TRIGGER validar_tamaño_documento
    BEFORE INSERT ON documentos
    FOR EACH ROW
BEGIN
    DECLARE tamaño_maximo BIGINT;

    SELECT CAST(valor AS UNSIGNED) INTO tamaño_maximo 
    FROM configuracion_sistema 
    WHERE clave = 'documentos.max_size';
    
    IF NEW.tamaño_archivo > tamaño_maximo THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'El archivo excede el tamaño máximo permitido';
    END IF;
END$$
DELIMITER ;
SQL);
    }

    public function down(): void
    {
        DB::unprepared('DROP VIEW IF EXISTS vista_estadisticas_carreras;');
        DB::unprepared('DROP PROCEDURE IF EXISTS EstadisticasPorRol;');
        DB::unprepared('DROP PROCEDURE IF EXISTS EspacioOcupadoDocumentos;');
        DB::unprepared('DROP TRIGGER IF EXISTS validar_tamaño_documento;');
    }
};

