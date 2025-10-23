<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UpdateUserPasswordsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Contraseñas que cumplen con los requisitos (8 caracteres máximo, números, letras y caracter especial)
        $passwords = [
            '0000000001' => 'Admin1!',    // Administrador del Sistema
            '2000000001' => 'Dir2024#',   // Dr. Juan Pérez García
            '2000000002' => 'Tutor1@',    // Ing. María González López
            '3522110579' => 'Ana2024$',   // Ana Sofía Martín Hernández
            '1000000001' => 'Biblio1#',   // Biblioteca UTH
        ];

        foreach ($passwords as $matricula => $password) {
            DB::table('users')
                ->where('matricula', $matricula)
                ->update([
                    'password' => Hash::make($password),
                    'updated_at' => now()
                ]);
        }

        // Mostrar las contraseñas para referencia (solo en desarrollo)
        echo "\n=== CONTRASEÑAS ACTUALIZADAS ===\n";
        echo "Matrícula: 0000000001 (admin@uth.edu.mx) - Contraseña: Admin1!\n";
        echo "Matrícula: 2000000001 (director.ti@uth.edu.mx) - Contraseña: Dir2024#\n";
        echo "Matrícula: 2000000002 (tutor01@uth.edu.mx) - Contraseña: Tutor1@\n";
        echo "Matrícula: 3522110579 (3522110579@uth.edu.mx) - Contraseña: Ana2024$\n";
        echo "Matrícula: 1000000001 (biblioteca@uth.edu.mx) - Contraseña: Biblio1#\n";
        echo "\nTodas las contraseñas cumplen con los requisitos:\n";
        echo "- Máximo 8 caracteres\n";
        echo "- Contienen números, letras y caracteres especiales\n";
        echo "- Están encriptadas con Bcrypt\n";
        echo "================================\n\n";
    }
}