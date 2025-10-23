<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Estadia;
use App\Models\Estudiante;
use App\Models\Profesor;
use App\Models\Empresa;
use Carbon\Carbon;

class EstadiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener estudiantes, profesores y empresas existentes
        $estudiantes = Estudiante::all();
        $profesores = Profesor::all();
        $empresas = Empresa::all();
        
        if ($estudiantes->isEmpty()) {
            $this->command->info('No hay estudiantes disponibles. Ejecuta primero EstudianteSeeder.');
            return;
        }
        
        if ($profesores->isEmpty()) {
            $this->command->info('No hay profesores disponibles. Ejecuta primero ProfesorSeeder.');
            return;
        }
        
        if ($empresas->isEmpty()) {
            $this->command->info('No hay empresas disponibles. Ejecuta primero EmpresaSeeder.');
            return;
        }
        
        // Crear estadías para cada estudiante que no tenga una estadía activa
        foreach ($estudiantes as $estudiante) {
            // Verificar si ya tiene una estadía activa
            $estadiaExistente = Estadia::where('estudiante_id', $estudiante->id)
                ->whereIn('status', ['en_proceso', 'documentos_pendientes', 'documentos_completos', 'validacion_biblioteca'])
                ->first();
                
            if (!$estadiaExistente) {
                // Asignar profesor y empresa aleatoriamente
                $profesor = $profesores->random();
                $empresa = $empresas->random();
                
                $fechaInicio = Carbon::now()->subMonths(2);
                $fechaFin = Carbon::now()->addMonths(4);
                
                Estadia::create([
                    'estudiante_id' => $estudiante->id,
                    'tutor_id' => $profesor->id,
                    'empresa_id' => $empresa->id,
                    'periodo' => '2024-2025',
                    'fecha_solicitud' => Carbon::now()->subMonths(3),
                    'fecha_inicio' => $fechaInicio,
                    'fecha_fin' => $fechaFin,
                    'status' => 'en_proceso',
                    'proyecto' => 'Desarrollo de Sistema de Gestión - ' . $empresa->nombre,
                    'area_empresa' => 'Tecnologías de la Información',
                    'modalidad' => 'presencial',
                    'horas_semanales' => 40,
                    'observaciones' => 'Estadía en proceso, estudiante desarrollando competencias profesionales.'
                ]);
                
                $this->command->info("Estadía creada para estudiante: {$estudiante->user->name} en empresa: {$empresa->nombre}");
            } else {
                $this->command->info("El estudiante {$estudiante->user->name} ya tiene una estadía activa");
            }
        }
        
        $this->command->info('✅ Estadías de ejemplo creadas exitosamente');
    }
}