<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Persona;
use App\Models\Users;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $adminPersona = Persona::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'apellidos'        => 'Admin',
                'nombres'          => 'Administrador',
                'dni'              => '00000000',
                'telefono'         => '',
                'direccion'        => '',
                'fecha_nacimiento' => '2000-01-01',
            ]
        );

        Users::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'persona_id' => $adminPersona->id,
                'name'       => 'Administrador',
                'email'      => 'admin@admin.com',
                'password'   => 'admin123',
                'role'       => 'admin',
            ]
        );
    }
}
