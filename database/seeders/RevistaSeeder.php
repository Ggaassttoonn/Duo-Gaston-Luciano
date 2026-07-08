<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SitRevista;

class RevistaSeeder extends Seeder
{
    public function run(): void
    {
        SitRevista::insert([
            ['revista' => 'Titular'],
            ['revista' => 'Interino'],
            ['revista' => 'Suplente'],
        ]);
    }
}
