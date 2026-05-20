<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('areas')->insert([
            [
                'area' => 'Lengua y Literatura',
                'tipo' => 'básica'
            ],
            [
                'area' => 'Matemática',
                'tipo' => 'básico'
            ],
            [
                'area' => 'Ciencias Sociales',
                'Tipo' => 'básico'
            ],
            [
                'area' => 'Ciencias Naturales',
                'tipo' => 'básico'
            ],
            [
                'area' => 'Educación Física',
                'tipo' => 'especial'
            ]
        ]);
    }

    public function down(): void
    {
        DB::table('areas')->truncate();
    }
}
