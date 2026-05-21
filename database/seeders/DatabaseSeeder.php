<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AreasSeeder::class,
            CargoSeeder::class,
            PersonasSeeder::class,
            PersonaCargoSeeder::class,
            CursosSeeder::class,
            CursadoSeeder::class,
            PersonaCargoCursadoSeeder::class,
            EstadoAnualSeeder::class,
            EstadoDiariaSeeder::class,
            PlanificacionAnualSeeder::class,
            PlanificacionDiariaSeeder::class,
            RevistaSeeder::class,
        ]);
    }
}
