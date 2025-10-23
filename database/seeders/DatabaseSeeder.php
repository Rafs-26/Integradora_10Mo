<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\Profesor;
use App\Models\Estudiante;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear roles
        $roles = [
            [
                'nombre' => 'Administrador',
                'slug' => 'administrador',
                'descripcion' => 'Acceso completo al sistema',
                'permisos' => ['*'],
                'activo' => true,
            ],
            [
                'nombre' => 'Director',
                'slug' => 'director',
                'descripcion' => 'Director de carrera',
                'permisos' => ['gestionar_carrera', 'ver_reportes'],
                'activo' => true,
            ],
            [
                'nombre' => 'Profesor',
                'slug' => 'profesor',
                'descripcion' => 'Profesor supervisor de estadías',
                'permisos' => ['supervisar_estadias', 'evaluar_estudiantes'],
                'activo' => true,
            ],
            [
                'nombre' => 'Estudiante',
                'slug' => 'estudiante',
                'descripcion' => 'Estudiante en estadías',
                'permisos' => ['ver_estadia', 'subir_documentos'],
                'activo' => true,
            ],
            [
                'nombre' => 'Biblioteca',
                'slug' => 'biblioteca',
                'descripcion' => 'Personal de biblioteca',
                'permisos' => ['gestionar_documentos'],
                'activo' => true,
            ],
        ];

        foreach ($roles as $roleData) {
            Role::create($roleData);
        }

        // Crear carreras
        $carrera = \App\Models\Carrera::create([
            'nombre' => 'Ingeniería en Sistemas Computacionales',
            'codigo' => 'ISC',
            'descripcion' => 'Carrera enfocada en el desarrollo de sistemas computacionales',
            'activa' => true,
        ]);

        // Obtener roles creados
        $adminRole = Role::where('slug', 'administrador')->first();
        $directorRole = Role::where('slug', 'director')->first();
        $profesorRole = Role::where('slug', 'profesor')->first();
        $estudianteRole = Role::where('slug', 'estudiante')->first();
        $bibliotecaRole = Role::where('slug', 'biblioteca')->first();

        // Crear usuario administrador
        $adminUser = User::create([
            'name' => 'Administrador del Sistema',
            'email' => 'admin@uth.edu.mx',
            'password' => Hash::make('Admin123@#'),
            'rol_id' => $adminRole->id,
            'email_verified_at' => now(),
        ]);

        // Crear usuario director
        $directorUser = User::create([
            'name' => 'Director de Carrera',
            'email' => 'director@uth.edu.mx',
            'password' => Hash::make('Director123@'),
            'rol_id' => $directorRole->id,
            'email_verified_at' => now(),
        ]);

        // Crear usuario profesor
        $profesorUser = User::create([
            'name' => 'Juan Pérez García',
            'email' => 'profesor@uth.edu.mx',
            'password' => Hash::make('Profesor123@'),
            'rol_id' => $profesorRole->id,
            'email_verified_at' => now(),
        ]);

        // Crear registro en tabla profesores
        Profesor::create([
            'user_id' => $profesorUser->id,
            'numero_empleado' => 'EMP001',
            'departamento' => 'Ingeniería en Sistemas',
            'titulo_academico' => 'Maestro en Ciencias',
            'especialidades_docencia' => 'Desarrollo de Software, Base de Datos',
            'activo_como_tutor' => true,
            'carrera_dirigida_id' => $carrera->id,
            'telefono' => '1234567890',
            'direccion' => 'Calle Principal 123',
            'ciudad' => 'Cancún',
            'estado' => 'Quintana Roo',
            'codigo_postal' => '77500',
        ]);

        // Crear usuario estudiante
        $estudianteUser = User::create([
            'name' => 'María González López',
            'email' => 'estudiante@uth.edu.mx',
            'password' => Hash::make('Estudiante123@'),
            'rol_id' => $estudianteRole->id,
            'email_verified_at' => now(),
        ]);

        // Crear registro en tabla estudiantes
        \App\Models\Estudiante::create([
            'user_id' => $estudianteUser->id,
            'matricula' => 'EST001',
            'carrera_id' => $carrera->id,
            'cuatrimestre' => 9,
            'telefono' => '0987654321',
            'fecha_nacimiento' => '2000-01-15',
            'direccion' => 'Avenida Secundaria 456',
            'ciudad' => 'Cancún',
            'estado' => 'Quintana Roo',
            'codigo_postal' => '77500',
        ]);

        // Crear segundo profesor
        $profesor2User = User::create([
            'name' => 'Ana María Rodríguez Silva',
            'email' => 'profesor2@uth.edu.mx',
            'password' => Hash::make('Profesor123@'),
            'rol_id' => $profesorRole->id,
            'email_verified_at' => now(),
        ]);

        // Crear registro en tabla profesores para segundo profesor
        Profesor::create([
            'user_id' => $profesor2User->id,
            'numero_empleado' => 'EMP002',
            'departamento' => 'Ingeniería en Sistemas',
            'titulo_academico' => 'Doctora en Ciencias Computacionales',
            'especialidades_docencia' => 'Inteligencia Artificial, Redes de Computadoras',
            'activo_como_tutor' => true,
            'carrera_dirigida_id' => $carrera->id,
            'telefono' => '1234567891',
            'direccion' => 'Avenida Universidad 789',
            'ciudad' => 'Cancún',
            'estado' => 'Quintana Roo',
            'codigo_postal' => '77500',
        ]);

        // Crear tercer profesor
        $profesor3User = User::create([
            'name' => 'Carlos Eduardo Martínez',
            'email' => 'profesor3@uth.edu.mx',
            'password' => Hash::make('Profesor123@'),
            'rol_id' => $profesorRole->id,
            'email_verified_at' => now(),
        ]);

        // Crear registro en tabla profesores para tercer profesor
        Profesor::create([
            'user_id' => $profesor3User->id,
            'numero_empleado' => 'EMP003',
            'departamento' => 'Ingeniería en Sistemas',
            'titulo_academico' => 'Maestro en Ingeniería de Software',
            'especialidades_docencia' => 'Programación Web, Metodologías Ágiles',
            'activo_como_tutor' => true,
            'carrera_dirigida_id' => $carrera->id,
            'telefono' => '1234567892',
            'direccion' => 'Calle Tecnológico 321',
            'ciudad' => 'Cancún',
            'estado' => 'Quintana Roo',
            'codigo_postal' => '77500',
        ]);

        // Crear segundo estudiante
        $estudiante2User = User::create([
            'name' => 'José Luis Hernández Pérez',
            'email' => 'estudiante2@uth.edu.mx',
            'password' => Hash::make('Estudiante123@'),
            'rol_id' => $estudianteRole->id,
            'email_verified_at' => now(),
        ]);

        // Crear registro en tabla estudiantes para segundo estudiante
        \App\Models\Estudiante::create([
            'user_id' => $estudiante2User->id,
            'matricula' => 'EST002',
            'carrera_id' => $carrera->id,
            'cuatrimestre' => 8,
            'telefono' => '0987654322',
            'fecha_nacimiento' => '2001-03-20',
            'direccion' => 'Calle Estudiantes 789',
            'ciudad' => 'Cancún',
            'estado' => 'Quintana Roo',
            'codigo_postal' => '77500',
        ]);

        // Crear tercer estudiante
        $estudiante3User = User::create([
            'name' => 'Sofía Alejandra Torres',
            'email' => 'estudiante3@uth.edu.mx',
            'password' => Hash::make('Estudiante123@'),
            'rol_id' => $estudianteRole->id,
            'email_verified_at' => now(),
        ]);

        // Crear registro en tabla estudiantes para tercer estudiante
        \App\Models\Estudiante::create([
            'user_id' => $estudiante3User->id,
            'matricula' => 'EST003',
            'carrera_id' => $carrera->id,
            'cuatrimestre' => 9,
            'telefono' => '0987654323',
            'fecha_nacimiento' => '2000-11-10',
            'direccion' => 'Avenida Juventud 456',
            'ciudad' => 'Cancún',
            'estado' => 'Quintana Roo',
            'codigo_postal' => '77500',
        ]);

        // Crear usuario biblioteca
        $bibliotecaUser = User::create([
            'name' => 'Personal de Biblioteca',
            'email' => 'biblioteca@uth.edu.mx',
            'password' => Hash::make('Biblioteca123@'),
            'rol_id' => $bibliotecaRole->id,
            'email_verified_at' => now(),
        ]);

        // Ejecutar otros seeders
        $this->call([
            EmpresaSeeder::class,
            EstadiaSeeder::class,
            SolicitudCartaPresentacionSeeder::class,
        ]);
    }
}
