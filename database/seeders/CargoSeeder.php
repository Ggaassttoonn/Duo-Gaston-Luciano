<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::Table('cargos')->insert([
            ['cargo' => 'Director/a'],
            ['cargo' => 'Maestro/a'],
            ['cargo' => 'Secretario/a'],
            ['cargo' => 'preceptor/a'],
            ['cargo' => 'Vice-director/a']
        ]);
    }
}
