<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Documento;
use App\Models\Estudiante;
use App\Models\Estadia;
use Carbon\Carbon;

class DocumentosMemoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener estudiantes y estadías existentes
        $estudiantes = Estudiante::with('estadiaActual')->get();
        
        if ($estudiantes->isEmpty()) {
            $this->command->info('No hay estudiantes disponibles. Ejecuta primero EstudianteSeeder.');
            return;
        }

        $documentos = [
            [
                'nombre_archivo' => 'Memoria_Estadia_Juan_Perez.pdf',
                'ruta_archivo' => 'documentos/memorias/memoria_juan_perez.pdf',
                'tipo_documento' => 'memoria_estadia',
                'tipo_mime' => 'application/pdf',
                'tamaño_archivo' => 2048576, // 2MB
                'hash_archivo' => hash('sha256', 'memoria_juan_perez_content'),
                'status' => 'pendiente',
                'fecha_subida' => Carbon::now()->subDays(5),
                'subido_por' => 1,
                'created_at' => Carbon::now()->subDays(5),
            ],
            [
                'nombre_archivo' => 'Memoria_Estadia_Maria_Garcia.pdf',
                'ruta_archivo' => 'documentos/memorias/memoria_maria_garcia.pdf',
                'tipo_documento' => 'memoria_estadia',
                'tipo_mime' => 'application/pdf',
                'tamaño_archivo' => 1536000, // 1.5MB
                'hash_archivo' => hash('sha256', 'memoria_maria_garcia_content'),
                'status' => 'validado',
                'fecha_subida' => Carbon::now()->subDays(10),
                'subido_por' => 2,
                'observaciones' => 'Memoria aprobada. Cumple con todos los requisitos establecidos.',
                'fecha_validacion' => Carbon::now()->subDays(2),
                'validado_por' => 1, // Usuario biblioteca
                'created_at' => Carbon::now()->subDays(10),
            ],
            [
                'nombre_archivo' => 'Memoria_Estadia_Carlos_Lopez.pdf',
                'ruta_archivo' => 'documentos/memorias/memoria_carlos_lopez.pdf',
                'tipo_documento' => 'memoria_estadia',
                'tipo_mime' => 'application/pdf',
                'tamaño_archivo' => 3072000, // 3MB
                'hash_archivo' => hash('sha256', 'memoria_carlos_lopez_content'),
                'status' => 'rechazado',
                'fecha_subida' => Carbon::now()->subDays(7),
                'subido_por' => 3,
                'observaciones' => 'La memoria no cumple con el formato requerido. Faltan las conclusiones y recomendaciones. Por favor, revise la guía de elaboración de memorias.',
                'fecha_validacion' => Carbon::now()->subDays(1),
                'validado_por' => 1, // Usuario biblioteca
                'created_at' => Carbon::now()->subDays(7),
            ],
            [
                'nombre_archivo' => 'Memoria_Estadia_Ana_Martinez.pdf',
                'ruta_archivo' => 'documentos/memorias/memoria_ana_martinez.pdf',
                'tipo_documento' => 'memoria_estadia',
                'tipo_mime' => 'application/pdf',
                'tamaño_archivo' => 2560000, // 2.5MB
                'hash_archivo' => hash('sha256', 'memoria_ana_martinez_content'),
                'status' => 'pendiente',
                'fecha_subida' => Carbon::now()->subDays(3),
                'subido_por' => 4,
                'created_at' => Carbon::now()->subDays(3),
            ],
            [
                'nombre_archivo' => 'Memoria_Estadia_Luis_Rodriguez.pdf',
                'ruta_archivo' => 'documentos/memorias/memoria_luis_rodriguez.pdf',
                'tipo_documento' => 'memoria_estadia',
                'tipo_mime' => 'application/pdf',
                'tamaño_archivo' => 1843200, // 1.8MB
                'hash_archivo' => hash('sha256', 'memoria_luis_rodriguez_content'),
                'status' => 'validado',
                'fecha_subida' => Carbon::now()->subDays(12),
                'subido_por' => 5,
                'observaciones' => 'Excelente trabajo. La memoria está muy bien estructurada y cumple con todos los requisitos.',
                'fecha_validacion' => Carbon::now()->subDays(4),
                'validado_por' => 1, // Usuario biblioteca
                'created_at' => Carbon::now()->subDays(12),
            ],
        ];

        foreach ($documentos as $index => $documentoData) {
            // Asignar estudiante (rotar entre los disponibles)
            $estudiante = $estudiantes[$index % $estudiantes->count()];
            
            $documentoData['estadia_id'] = $estudiante->estadiaActual ? $estudiante->estadiaActual->id : null;
            
            if ($documentoData['estadia_id']) {
                Documento::create($documentoData);
            }
        }

        $this->command->info('Documentos de memoria de estadía creados exitosamente.');
    }
}