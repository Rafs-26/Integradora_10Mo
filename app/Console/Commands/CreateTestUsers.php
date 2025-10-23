<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class CreateTestUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-test-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crear usuarios de prueba para el sistema';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creando usuarios de prueba...');

        // Crear usuarios de prueba sin roles por ahora
        $users = [
            [
                'name' => 'Administrador Sistema',
                'email' => 'admin@uth.edu.mx',
                'password' => Hash::make('Admin123!')
            ],
            [
                'name' => 'Director Estadias',
                'email' => 'director@uth.edu.mx',
                'password' => Hash::make('Dir123!')
            ],
            [
                'name' => 'Profesor Asesor',
                'email' => 'profesor@uth.edu.mx',
                'password' => Hash::make('Prof123!')
            ],
            [
                'name' => 'Estudiante Prueba',
                'email' => 'estudiante@uth.edu.mx',
                'password' => Hash::make('Est123!')
            ]
        ];

        foreach ($users as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );

            $this->info("Usuario creado: {$user->email}");
        }

        $this->info('¡Usuarios de prueba creados exitosamente!');
        $this->info('Credenciales de acceso:');
        $this->info('Admin: admin@uth.edu.mx / Admin123!');
        $this->info('Director: director@uth.edu.mx / Dir123!');
        $this->info('Profesor: profesor@uth.edu.mx / Prof123!');
        $this->info('Estudiante: estudiante@uth.edu.mx / Est123!');
    }
}
