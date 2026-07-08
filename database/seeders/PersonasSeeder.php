<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonasSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('personas')->insertOrIgnore([
            [
                'apellidos' => 'García',
                'nombres' => 'Juan',
                'dni' => '12345678',
                'email' => 'juangarcia@example.com',
                'telefono' => '111111111',
                'direccion' => 'Calle 1',
                'fecha_nacimiento' => '1990-01-01'
            ],
            [
                'apellidos' => "Azula",
                'nombres' => 'Gastón',
                'dni' => '11111111',
                'email' => 'gastonazula@example.com',
                'telefono' => '222222222',
                'direccion' => 'Calle 2',
                'fecha_nacimiento' => '1995-05-15'
            ],
            [
                'apellidos' => 'Juanes',
                'nombres' => 'Margarita',
                'dni' => '22222222',
                'email' => 'margarita@example.com',
                'telefono' => '333333333',
                'direccion' => 'Calle 3',
                'fecha_nacimiento' => '1985-10-20'
            ],
            [
                'apellidos' => 'Monzón',
                'nombres' => 'Luis Miguel',
                'dni' => '33333333',
                'email' => 'Luismi@example.com',
                'telefono' => '444444444',
                'direccion' => 'Calle 4',
                'fecha_nacimiento' => '2000-03-08'
            ],
            [
                'apellidos' => 'Gonalez',
                'nombres' => 'Amanda',
                'dni' => '44444444',
                'email' => 'Amagonzalez@gmail.com',
                'telefono' => '555555555',
                'direccion' => 'Calle 5',
                'fecha_nacimiento' => '1992-07-25'
            ]
        ]);
    }

    public function down(): void
    {
        DB::table('personas')->truncate();
    }
}
