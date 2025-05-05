<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Administrador
        User::create([
            'nombre' => 'Admin',
            'primer_apellido' => 'Sistema',
            'segundo_apellido' => null,
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'id_rol' => 1, // Administrador
        ]);

        // Usuario normal
        User::create([
            'nombre' => 'Usuario',
            'primer_apellido' => 'Normal',
            'segundo_apellido' => 'Test',
            'email' => 'usuario@example.com',
            'password' => Hash::make('password'),
            'id_rol' => 2, // Usuario
        ]);
    }
}