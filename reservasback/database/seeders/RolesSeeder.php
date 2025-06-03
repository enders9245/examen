<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        // Crear roles si no existen
        $roles = ['superadmin', 'emprendedor', 'turista'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Verificar si el usuario ya existe, si no lo crea, especificando ID=1
        $user = User::firstOrCreate(
            ['email' => 'fkanachullo12@gmail.com'],
            [
                'id' => 1, // <<--- Añadir esta línea para asegurar el ID
                'name' => 'Super Admin',
                'password' => Hash::make('fraykana10'),
            ]
        );

        // Asignar el rol de superadmin al usuario
        $user->assignRole('superadmin');
    }
}
