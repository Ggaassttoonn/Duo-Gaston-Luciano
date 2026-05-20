<?php

namespace Database\Seeders;

use database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonasSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('personas')->insert([
            [
                'apellidos' => 'García',
                'nombres' => 'Juan',
                'dni' => '12345678',
                'e-mail' => 'juangarcia@example.com'
            ],
            [
                'apellidos' => "Azula",
                'nombres' => 'Gastón',
                'dni' => '11111111',
                'e-mail' => 'gastónaluzla@example.com'
            ],
            [
                'apellidos' => 'Juanes',
                'nombres' => 'Margarita',
                'dni' => '22222222',
                'e-mail' => 'margarita@example.com'
            ],
            [
                'apellidos' => 'Monzón',
                'nombres' => 'Luis Miguel',
                'dni' => '33333333',
                'e-mail' => 'Luismi@example.com'

            ],
            [
                'apellidos' => 'Gonalez',
                'nombres' => 'Amanda',
                'dni' => '22222222',
                'e-mail' => 'Amagonzalez@gmail.com'
            ]
        ]);
    }
}
