<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear roles
        $adminRole = Role::create([
            'nombre' => 'Administrador',
            'slug' => 'administrador',
            'descripcion' => 'Administrador del sistema',
            'permisos' => [
                'usuarios' => ['crear', 'leer', 'actualizar', 'eliminar'],
                'roles' => ['crear', 'leer', 'actualizar', 'eliminar'],
                'estudiantes' => ['crear', 'leer', 'actualizar', 'eliminar'],
                'profesores' => ['crear', 'leer', 'actualizar', 'eliminar'],
                'empresas' => ['crear', 'leer', 'actualizar', 'eliminar'],
                'estadias' => ['crear', 'leer', 'actualizar', 'eliminar'],
                'reportes' => ['generar', 'exportar'],
                'configuracion' => ['leer', 'actualizar']
            ],
            'activo' => true
        ]);

        $directorRole = Role::create([
            'nombre' => 'Director',
            'slug' => 'director',
            'descripcion' => 'Director de estadías',
            'permisos' => [
                'estudiantes' => ['crear', 'leer', 'actualizar'],
                'profesores' => ['leer'],
                'empresas' => ['crear', 'leer', 'actualizar'],
                'estadias' => ['crear', 'leer', 'actualizar'],
                'reportes' => ['generar', 'exportar']
            ],
            'activo' => true
        ]);

        $profesorRole = Role::create([
            'nombre' => 'Profesor',
            'slug' => 'profesor',
            'descripcion' => 'Profesor supervisor',
            'permisos' => [
                'estudiantes' => ['leer'],
                'estadias' => ['leer', 'actualizar'],
                'documentos' => ['leer', 'actualizar'],
                'citas' => ['crear', 'leer', 'actualizar']
            ],
            'activo' => true
        ]);

        $estudianteRole = Role::create([
            'nombre' => 'Estudiante',
            'slug' => 'estudiante',
            'descripcion' => 'Estudiante en estadías',
            'permisos' => [
                'perfil' => ['leer', 'actualizar'],
                'estadia' => ['leer'],
                'documentos' => ['crear', 'leer'],
                'citas' => ['leer']
            ],
            'activo' => true
        ]);

        // Crear usuarios de prueba
        User::create([
            'name' => 'Administrador Sistema',
            'email' => 'admin@uth.edu.mx',
            'password' => Hash::make('Admin123!'),
            'rol_id' => $adminRole->id,
            'email_verified_at' => now()
        ]);

        User::create([
            'name' => 'Director Estadías',
            'email' => 'director@uth.edu.mx',
            'password' => Hash::make('Dir123!'),
            'rol_id' => $directorRole->id,
            'email_verified_at' => now()
        ]);

        User::create([
            'name' => 'Profesor Supervisor',
            'email' => 'profesor@uth.edu.mx',
            'password' => Hash::make('Prof123!'),
            'rol_id' => $profesorRole->id,
            'email_verified_at' => now()
        ]);

        User::create([
            'name' => 'Estudiante Prueba',
            'email' => 'estudiante@uth.edu.mx',
            'password' => Hash::make('Est123!'),
            'rol_id' => $estudianteRole->id,
            'email_verified_at' => now()
        ]);

        $this->command->info('Datos de prueba creados exitosamente:');
        $this->command->info('- admin@uth.edu.mx / Admin123!');
        $this->command->info('- director@uth.edu.mx / Dir123!');
        $this->command->info('- profesor@uth.edu.mx / Prof123!');
        $this->command->info('- estudiante@uth.edu.mx / Est123!');
    }
}
