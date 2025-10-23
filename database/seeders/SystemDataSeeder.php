<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Carrera;
use App\Models\Empresa;
use Carbon\Carbon;

class SystemDataSeeder extends Seeder
{
    public function run()
    {
        // Crear roles
        $roles = [
            ['nombre' => 'administrador', 'descripcion' => 'Administrador del sistema'],
            ['nombre' => 'director', 'descripcion' => 'Director de carrera'],
            ['nombre' => 'profesor', 'descripcion' => 'Profesor tutor'],
            ['nombre' => 'estudiante', 'descripcion' => 'Estudiante'],
            ['nombre' => 'biblioteca', 'descripcion' => 'Personal de biblioteca']
        ];

        foreach ($roles as $roleData) {
            Role::firstOrCreate(
                ['nombre' => $roleData['nombre']],
                $roleData
            );
        }

        // Crear carreras
        $carreras = [
            [
                'nombre' => 'Ingeniería en Sistemas Computacionales',
                'codigo' => 'ISC',
                'descripcion' => 'Carrera enfocada en el desarrollo de sistemas de información'
            ],
            [
                'nombre' => 'Ingeniería Industrial',
                'codigo' => 'II',
                'descripcion' => 'Carrera enfocada en la optimización de procesos industriales'
            ],
            [
                'nombre' => 'Ingeniería en Gestión Empresarial',
                'codigo' => 'IGE',
                'descripcion' => 'Carrera enfocada en la administración y gestión de empresas'
            ],
            [
                'nombre' => 'Ingeniería Mecatrónica',
                'codigo' => 'IM',
                'descripcion' => 'Carrera que combina mecánica, electrónica y sistemas de control'
            ]
        ];

        foreach ($carreras as $carreraData) {
            Carrera::firstOrCreate(
                ['codigo' => $carreraData['codigo']],
                $carreraData
            );
        }

        // Crear empresas
        $empresas = [
            [
                'razon_social' => 'TechSolutions SA de CV',
                'nombre_comercial' => 'TechSolutions',
                'rfc' => 'TSO120515ABC',
                'giro' => 'Desarrollo de software',
                'sector' => 'Tecnología',
                'tamaño' => 'mediana',
                'direccion' => 'Av. Tecnológico 123, Col. Industrial',
                'ciudad' => 'Tulancingo',
                'estado' => 'Hidalgo',
                'codigo_postal' => '43600',
                'telefono' => '7717123456',
                'email' => 'contacto@techsolutions.com.mx',
                'sitio_web' => 'www.techsolutions.com.mx',
                'contacto_nombre' => 'Ing. María González López',
                'contacto_puesto' => 'Gerente de Recursos Humanos',
                'contacto_telefono' => '7717123456',
                'contacto_email' => 'maria.gonzalez@techsolutions.com.mx',
                'observaciones' => 'Empresa especializada en desarrollo de software empresarial',
                'status' => 'activa'
            ],
            [
                'razon_social' => 'Industrias del Centro SA',
                'nombre_comercial' => 'Industrias del Centro',
                'rfc' => 'IDC980312XYZ',
                'giro' => 'Manufactura industrial',
                'sector' => 'Industrial',
                'tamaño' => 'grande',
                'direccion' => 'Carretera México-Pachuca Km 87',
                'ciudad' => 'Tulancingo',
                'estado' => 'Hidalgo',
                'codigo_postal' => '43640',
                'telefono' => '7717654321',
                'email' => 'rh@industriascentro.com',
                'sitio_web' => 'www.industriascentro.com',
                'contacto_nombre' => 'Lic. Carlos Hernández Ruiz',
                'contacto_puesto' => 'Director de Recursos Humanos',
                'contacto_telefono' => '7717654321',
                'contacto_email' => 'carlos.hernandez@industriascentro.com',
                'observaciones' => 'Empresa manufacturera con más de 25 años de experiencia',
                'status' => 'activa'
            ],
            [
                'razon_social' => 'Consultores Empresariales del Valle SC',
                'nombre_comercial' => 'Consultores del Valle',
                'rfc' => 'CEV050807DEF',
                'giro' => 'Consultoría empresarial',
                'sector' => 'Servicios',
                'tamaño' => 'pequeña',
                'direccion' => 'Blvd. Felipe Ángeles 456, Col. Centro',
                'ciudad' => 'Tulancingo',
                'estado' => 'Hidalgo',
                'codigo_postal' => '43600',
                'telefono' => '7717987654',
                'email' => 'info@consultoresvalle.mx',
                'sitio_web' => 'www.consultoresvalle.mx',
                'contacto_nombre' => 'Mtro. Ana Patricia Morales',
                'contacto_puesto' => 'Directora General',
                'contacto_telefono' => '7717987654',
                'contacto_email' => 'ana.morales@consultoresvalle.mx',
                'observaciones' => 'Consultoría especializada en mejora de procesos empresariales',
                'status' => 'activa'
            ]
        ];

        foreach ($empresas as $empresaData) {
            Empresa::firstOrCreate(
                ['rfc' => $empresaData['rfc']],
                $empresaData
            );
        }

        // Crear usuarios
        $usuarios = [
            [
                'name' => 'Administrador del Sistema',
                'email' => 'admin@uth.edu.mx',
                'password' => Hash::make('Admin123@#'),
                'role' => 'administrador'
            ],
            [
                'name' => 'Director de Carrera ISC',
                'email' => 'director@uth.edu.mx',
                'password' => Hash::make('Director123@'),
                'role' => 'director',
                'carrera_id' => 1
            ],
            [
                'name' => 'Prof. Juan Carlos Pérez',
                'email' => 'profesor@uth.edu.mx',
                'password' => Hash::make('Profesor123@'),
                'role' => 'profesor',
                'carrera_id' => 1
            ],
            [
                'name' => 'María Fernanda López Sánchez',
                'email' => 'estudiante@uth.edu.mx',
                'password' => Hash::make('Estudiante123@'),
                'role' => 'estudiante',
                'carrera_id' => 1,
                'numero_control' => '20210001',
                'semestre' => 9
            ],
            [
                'name' => 'Personal de Biblioteca',
                'email' => 'biblioteca@uth.edu.mx',
                'password' => Hash::make('Biblioteca123@'),
                'role' => 'biblioteca'
            ],
            // Usuarios adicionales para pruebas
            [
                'name' => 'Prof. Laura Martínez García',
                'email' => 'laura.martinez@uth.edu.mx',
                'password' => Hash::make('Profesor123@'),
                'role' => 'profesor',
                'carrera_id' => 2
            ],
            [
                'name' => 'Carlos Eduardo Ramírez',
                'email' => 'carlos.ramirez@uth.edu.mx',
                'password' => Hash::make('Estudiante123@'),
                'role' => 'estudiante',
                'carrera_id' => 1,
                'numero_control' => '20210002',
                'semestre' => 8
            ],
            [
                'name' => 'Ana Sofía Hernández',
                'email' => 'ana.hernandez@uth.edu.mx',
                'password' => Hash::make('Estudiante123@'),
                'role' => 'estudiante',
                'carrera_id' => 2,
                'numero_control' => '20210003',
                'semestre' => 9
            ]
        ];

        foreach ($usuarios as $userData) {
            $role = Role::where('nombre', $userData['role'])->first();
            
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => $userData['password'],
                    'rol_id' => $role->id,
                    'email_verified_at' => now()
                ]
            );
        }

        // Los datos de estadías, documentos y citas se crearán posteriormente
        // cuando se implementen las tablas correspondientes en el sistema

        $this->command->info('Datos del sistema insertados correctamente.');
        $this->command->info('Usuarios creados:');
        $this->command->info('- Administrador: admin@uth.edu.mx / Admin123@#');
        $this->command->info('- Director: director@uth.edu.mx / Director123@');
        $this->command->info('- Profesor: profesor@uth.edu.mx / Profesor123@');
        $this->command->info('- Estudiante: estudiante@uth.edu.mx / Estudiante123@');
        $this->command->info('- Biblioteca: biblioteca@uth.edu.mx / Biblioteca123@');
    }
}