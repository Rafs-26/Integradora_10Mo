<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Configuración de Documentos
    |--------------------------------------------------------------------------
    |
    | Esta configuración define los parámetros para el manejo de documentos
    | en el sistema de estadías.
    |
    */

    'storage' => [
        'disk' => 'public',
        'path' => 'documentos/estudiantes',
    ],

    'validation' => [
        'max_size' => 10240, // 10MB en KB
        'allowed_mimes' => ['pdf', 'doc', 'docx'],
        'allowed_extensions' => ['pdf', 'doc', 'docx'],
    ],

    'tipos_documento' => [
        'carta_presentacion' => 'Carta de Presentación',
        'carta_aceptacion' => 'Carta de Aceptación',
        'cronograma_actividades' => 'Cronograma de Actividades',
        'carta_terminacion' => 'Carta de Terminación',
        'evaluacion_empresa' => 'Evaluación de Empresa',
        'evaluacion_tutor' => 'Evaluación de Tutor',
        'memoria_estadia' => 'Memoria de Estadía',
    ],

    'security' => [
        'hash_algorithm' => 'sha256',
        'check_duplicates' => true,
        'virus_scan' => false, // Activar cuando se implemente
    ],

    'backup' => [
        'enabled' => true,
        'retention_days' => 365,
    ],
];