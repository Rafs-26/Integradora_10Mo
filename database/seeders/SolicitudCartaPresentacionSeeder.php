<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SolicitudCartaPresentacion;
use App\Models\Estudiante;
use App\Models\Estadia;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SolicitudCartaPresentacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Deshabilitar verificación de claves foráneas temporalmente
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Limpiar tabla existente
        SolicitudCartaPresentacion::truncate();
        
        // Obtener datos necesarios
        $estudiante = Estudiante::first();
        $estadia = Estadia::first();
        $coordinador = User::whereHas('role', function($query) {
            $query->where('slug', 'director');
        })->first();
        
        if ($estudiante && $estadia && $coordinador) {
            // Crear solicitudes de ejemplo
            $solicitudes = [
                [
                    'estudiante_id' => $estudiante->id,
                    'estadia_id' => $estadia->id,
                    'dirigida_a' => 'Ing. María González',
                    'cargo_destinatario' => 'Gerente de Recursos Humanos',
                    'proposito' => 'presentacion_estudiante',
                    'observaciones' => 'Solicitud aprobada para descarga',
                    'estado' => 'aprobada_director',
                    'fecha_solicitud' => now()->subDays(3),
                    'fecha_procesada' => now()->subDay(),
                    'procesada_por' => $coordinador->id,
                    'comentarios_coordinador' => 'Solicitud aprobada. El estudiante cumple con todos los requisitos.',
                    'archivo_carta' => null,
                    'created_at' => now()->subDays(3),
                    'updated_at' => now()->subDay(),
                ],
                [
                    'estudiante_id' => $estudiante->id,
                    'estadia_id' => $estadia->id,
                    'dirigida_a' => 'Lic. Carlos Rodríguez',
                    'cargo_destinatario' => 'Director de Tecnología',
                    'proposito' => 'solicitud_estadias',
                    'observaciones' => 'Carta generada y lista para descarga',
                    'estado' => 'generada',
                    'fecha_solicitud' => now()->subDays(5),
                    'fecha_procesada' => now()->subDays(2),
                    'procesada_por' => $coordinador->id,
                    'comentarios_coordinador' => 'Solicitud aprobada. Carta generada exitosamente.',
                    'archivo_carta' => 'cartas/carta_presentacion_' . $estudiante->id . '_' . now()->subDays(2)->format('Y_m_d') . '.pdf',
                    'created_at' => now()->subDays(5),
                    'updated_at' => now()->subDays(2),
                ],
                [
                    'estudiante_id' => $estudiante->id,
                    'estadia_id' => $estadia->id,
                    'dirigida_a' => 'Mtra. Laura Jiménez',
                    'cargo_destinatario' => 'Coordinadora de Prácticas',
                    'proposito' => 'otro',
                    'observaciones' => 'Solicitud especial para realizar estadías en modalidad virtual debido a circunstancias especiales.',
                    'estado' => 'rechazada_profesor',
                    'fecha_solicitud' => now()->subDays(15),
                    'fecha_procesada' => now()->subDays(12),
                    'procesada_por' => $coordinador->id,
                    'comentarios_coordinador' => 'No se puede aprobar modalidad virtual para esta carrera.',
                    'archivo_carta' => null,
                    'created_at' => now()->subDays(15),
                    'updated_at' => now()->subDays(12),
                ]
            ];
            
            foreach ($solicitudes as $solicitud) {
                SolicitudCartaPresentacion::create($solicitud);
            }
        }
        
        // Rehabilitar verificación de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}