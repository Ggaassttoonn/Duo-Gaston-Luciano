<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Persona;
use App\Models\Users;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $adminPersona = Persona::where('email', 'gastonazula@example.com')->first();

        if ($adminPersona) {
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
}
