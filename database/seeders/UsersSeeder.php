<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener los roles
        $adminRole = Role::where('nombre', 'Administrador')->first();
        $directorRole = Role::where('nombre', 'Director')->first();
        $profesorRole = Role::where('nombre', 'Profesor')->first();
        $estudianteRole = Role::where('nombre', 'Estudiante')->first();
        $bibliotecaRole = Role::where('nombre', 'Biblioteca')->first();

        // Crear usuario Administrador
        User::updateOrCreate(
            ['email' => 'admin@uth.edu.mx'],
            [
                'name' => 'Administrador UTH',
                'email' => 'admin@uth.edu.mx',
                'password' => Hash::make('Admin123@#'),
                'rol_id' => $adminRole->id,
                'email_verified_at' => now(),
            ]
        );

        // Crear usuario Director
        User::updateOrCreate(
            ['email' => 'director@uth.edu.mx'],
            [
                'name' => 'Director UTH',
                'email' => 'director@uth.edu.mx',
                'password' => Hash::make('Director123@'),
                'rol_id' => $directorRole->id,
                'email_verified_at' => now(),
            ]
        );

        // Crear usuario Profesor
        User::updateOrCreate(
            ['email' => 'profesor@uth.edu.mx'],
            [
                'name' => 'Profesor UTH',
                'email' => 'profesor@uth.edu.mx',
                'password' => Hash::make('Profesor123@'),
                'rol_id' => $profesorRole->id,
                'email_verified_at' => now(),
            ]
        );

        // Crear usuario Estudiante
        User::updateOrCreate(
            ['email' => 'estudiante@uth.edu.mx'],
            [
                'name' => 'Estudiante UTH',
                'email' => 'estudiante@uth.edu.mx',
                'password' => Hash::make('Estudiante123@'),
                'rol_id' => $estudianteRole->id,
                'email_verified_at' => now(),
            ]
        );

        // Crear usuario Biblioteca
        User::updateOrCreate(
            ['email' => 'biblioteca@uth.edu.mx'],
            [
                'name' => 'Biblioteca UTH',
                'email' => 'biblioteca@uth.edu.mx',
                'password' => Hash::make('Biblioteca123@'),
                'rol_id' => $bibliotecaRole->id,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Usuarios de prueba creados exitosamente:');
        $this->command->info('Admin: admin@uth.edu.mx / Admin123@#');
        $this->command->info('Director: director@uth.edu.mx / Director123@');
        $this->command->info('Profesor: profesor@uth.edu.mx / Profesor123@');
        $this->command->info('Estudiante: estudiante@uth.edu.mx / Estudiante123@');
        $this->command->info('Biblioteca: biblioteca@uth.edu.mx / Biblioteca123@');
    }
}
