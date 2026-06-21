<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PersonaCargo;
use App\Models\Cursado;
use App\Models\Cargo;
use App\Models\PersonaCargoCursado;

class PersonaCargoCursadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cursados = Cursado::all();

        $cargoMaestro = Cargo::where('cargo', 'Maestro/a')->first();

        $designacionesMaestros = PersonaCargo::where('cargos_id', $cargoMaestro->id)->get();

        if ($cursados->isEmpty() || $designacionesMaestros->isEmpty()) {
            return;
        }

        foreach ($cursados as $index => $cursado) {
            $designacionAsignar = $designacionesMaestros->get($index % $designacionesMaestros->count());

            PersonaCargoCursado::create([
                'persona_cargos_id' => $designacionAsignar->id,
                'cursados_id' => $cursado->id,
            ]);
        }
    }
}
