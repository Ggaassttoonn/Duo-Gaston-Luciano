<?php

namespace Database\Seeders;

use Database\Console\Seeds\WithoutModelEvents;
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
                'email' => 'juangarcia@example.com'
            ],
            [
                'apellidos' => "Azula",
                'nombres' => 'Gastón',
                'dni' => '11111111',
                'email' => 'gastónaluzla@example.com'
            ],
            [
                'apellidos' => 'Juanes',
                'nombres' => 'Margarita',
                'dni' => '22222222',
                'email' => 'margarita@example.com'
            ],
            [
                'apellidos' => 'Monzón',
                'nombres' => 'Luis Miguel',
                'dni' => '33333333',
                'email' => 'Luismi@example.com'

            ],
            [
                'apellidos' => 'Gonalez',
                'nombres' => 'Amanda',
                'dni' => '44444444',
                'email' => 'Amagonzalez@gmail.com'
            ]
        ]);
    }

    public function down(): void
    {
        DB::table('personas')->truncate();
    }
}
