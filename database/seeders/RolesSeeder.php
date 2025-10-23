<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'nombre' => 'Administrador',
                'slug' => 'administrador',
                'descripcion' => 'Administrador del sistema con acceso completo',
                'permisos' => json_encode([
                    'usuarios' => ['crear', 'leer', 'actualizar', 'eliminar'],
                    'roles' => ['crear', 'leer', 'actualizar', 'eliminar'],
                    'carreras' => ['crear', 'leer', 'actualizar', 'eliminar'],
                    'especialidades' => ['crear', 'leer', 'actualizar', 'eliminar'],
                    'estudiantes' => ['crear', 'leer', 'actualizar', 'eliminar'],
                    'profesores' => ['crear', 'leer', 'actualizar', 'eliminar'],
                    'empresas' => ['crear', 'leer', 'actualizar', 'eliminar'],
                    'estadias' => ['crear', 'leer', 'actualizar', 'eliminar'],
                    'documentos' => ['crear', 'leer', 'actualizar', 'eliminar'],
                    'citas' => ['crear', 'leer', 'actualizar', 'eliminar'],
                    'notificaciones' => ['crear', 'leer', 'actualizar', 'eliminar'],
                    'configuracion' => ['crear', 'leer', 'actualizar', 'eliminar'],
                    'logs' => ['leer'],
                    'reportes' => ['generar', 'exportar']
                ]),
                'activo' => true
            ],
            [
                'nombre' => 'Director',
                'slug' => 'director',
                'descripcion' => 'Director de carrera con permisos de gestión académica',
                'permisos' => json_encode([
                    'estudiantes' => ['crear', 'leer', 'actualizar'],
                    'profesores' => ['leer', 'actualizar'],
                    'empresas' => ['crear', 'leer', 'actualizar'],
                    'estadias' => ['crear', 'leer', 'actualizar'],
                    'documentos' => ['leer', 'actualizar'],
                    'citas' => ['leer'],
                    'asignaciones' => ['crear', 'leer', 'actualizar'],
                    'reportes' => ['generar', 'exportar']
                ]),
                'activo' => true
            ],
            [
                'nombre' => 'Profesor',
                'slug' => 'profesor',
                'descripcion' => 'Profesor tutor con permisos de seguimiento de estadías',
                'permisos' => json_encode([
                    'estudiantes' => ['leer'],
                    'estadias' => ['leer', 'actualizar'],
                    'documentos' => ['leer', 'actualizar'],
                    'citas' => ['crear', 'leer', 'actualizar'],
                    'evaluaciones' => ['crear', 'leer', 'actualizar']
                ]),
                'activo' => true
            ],
            [
                'nombre' => 'Estudiante',
                'slug' => 'estudiante',
                'descripcion' => 'Estudiante con permisos básicos para gestionar su estadía',
                'permisos' => json_encode([
                    'perfil' => ['leer', 'actualizar'],
                    'estadia' => ['leer'],
                    'documentos' => ['crear', 'leer'],
                    'citas' => ['crear', 'leer', 'actualizar']
                ]),
                'activo' => true
            ],
            [
                'nombre' => 'Biblioteca',
                'slug' => 'biblioteca',
                'descripcion' => 'Personal de biblioteca con permisos para validación de memorias de estadía',
                'permisos' => json_encode([
                    'estudiantes' => ['leer'],
                    'estadias' => ['leer'],
                    'documentos' => ['leer', 'actualizar'],
                    'memorias' => ['leer', 'validar', 'rechazar'],
                    'validaciones' => ['crear', 'leer', 'actualizar'],
                    'reportes' => ['generar']
                ]),
                'activo' => true
            ]
        ];

        foreach ($roles as $rol) {
            Role::updateOrCreate(
                ['nombre' => $rol['nombre']],
                $rol
            );
        }
    }
}
