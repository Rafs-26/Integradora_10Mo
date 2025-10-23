<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Profesor;
use App\Models\Estudiante;
use App\Models\AsignacionTutor;
use App\Models\Carrera;
class AsignacionTutorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear profesor por defecto si no existe
        $profesorUser = User::firstOrCreate(
            ['email' => 'tutor.default@uth.edu.mx'],
            [
                'name' => 'Tutor Por Defecto',
                'password' => Hash::make('TutorUTH2024!'),
                'email_verified_at' => now(),
            ]
        );

        // Crear registro de profesor si no existe
        $profesor = Profesor::firstOrCreate(
            ['user_id' => $profesorUser->id],
            [
                'numero_empleado' => 'EMP001',
                'departamento' => 'Sistemas Computacionales',
                'titulo_academico' => 'Maestría en Sistemas Computacionales',
                'especialidades_docencia' => 'Desarrollo de software, bases de datos, estadías',
                'activo_como_tutor' => true,
                'telefono' => '7771111111',
                'ciudad' => 'Tulancingo',
                'estado' => 'Hidalgo',
                'codigo_postal' => '43600',
            ]
        );
        
        // Buscar estudiantes sin tutor asignado
        $estudiantes = Estudiante::all();
        
        foreach ($estudiantes as $estudiante) {
            // Verificar si ya tiene una asignación activa
            $asignacionExistente = AsignacionTutor::where('estudiante_id', $estudiante->id)
                ->where('status', 'activa')
                ->first();
                
            if (!$asignacionExistente) {
                AsignacionTutor::create([
                    'tutor_id' => $profesor->id,
                    'estudiante_id' => $estudiante->id,
                    'carrera_id' => $estudiante->carrera_id,
                    'director_id' => $profesor->id, // Por simplicidad, el mismo profesor es director
                    'periodo' => '2024-2025',
                    'status' => 'activa',
                ]);
                
                echo "Tutor asignado al estudiante: {$estudiante->user->name}\n";
            }
        }
    }
}