<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Estudiante;
use App\Models\Carrera;

class EstudianteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buscar usuarios con rol de estudiante (rol_id = 4)
        $usuariosEstudiantes = User::where('rol_id', 4)->get();
        
        // Crear carrera por defecto si no existe
        $carrera = Carrera::firstOrCreate(
            ['nombre' => 'Ingeniería en Sistemas Computacionales'],
            [
                'codigo' => 'ISC',
                'descripcion' => 'Carrera de Ingeniería en Sistemas Computacionales',
                'activa' => true
            ]
        );
        
        $contador = 1;
        foreach ($usuariosEstudiantes as $usuario) {
            // Verificar si ya tiene registro de estudiante
            if (!$usuario->estudiante) {
                $matricula = 'EST' . str_pad($contador, 6, '0', STR_PAD_LEFT);
                
                Estudiante::create([
                    'user_id' => $usuario->id,
                    'carrera_id' => $carrera->id,
                    'matricula' => $matricula,
                    'cuatrimestre' => 7,
                    'telefono' => '7771234567',
                    'direccion' => 'Calle Principal #123, Pachuca, Hidalgo',
                    'fecha_nacimiento' => '2000-01-01',
                    'ciudad' => 'Pachuca',
                    'estado' => 'Hidalgo',
                    'codigo_postal' => '42000'
                ]);
                
                echo "Registro de estudiante creado para: {$usuario->name} con matrícula: {$matricula}\n";
                $contador++;
            } else {
                // Si ya existe, actualizar la matrícula si no la tiene
                if (empty($usuario->estudiante->matricula)) {
                    $matricula = 'EST' . str_pad($contador, 6, '0', STR_PAD_LEFT);
                    $usuario->estudiante->update(['matricula' => $matricula]);
                    echo "Matrícula {$matricula} asignada a: {$usuario->name}\n";
                    $contador++;
                } else {
                    echo "El usuario {$usuario->name} ya tiene registro de estudiante con matrícula: {$usuario->estudiante->matricula}\n";
                }
            }
        }
    }
}