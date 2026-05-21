<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Persona;
use App\Models\Cargo;
use App\Models\SitRevista;
use App\Models\PersonaCargo;

class PersonaCargoSeeder extends Seeder
{

    public function run(): void
    {

        $personas = Persona::all();

        $cargoDirector = Cargo::where('cargo', 'Director/a')->first();
        $cargoMaestro = Cargo::where('cargo', 'Maestro/a')->first();
        $cargoSecretario = Cargo::where('cargo', 'Secretario/a')->first();
        $cargoPreceptor = Cargo::where('cargo', 'preceptor/a')->first();
        $cargoVicedirector = Cargo::where('cargo', 'Vice-director/a')->first();

        $sitTitular = SitRevista::where('revista', 'Titular')->first();
        $sitInterino = SitRevista::where('revista', 'Interino')->first();
        $sitSuplente = SitRevista::where('revista', 'Suplente')->first();


        if ($personas->isEmpty()) {
            return;
        }


        PersonaCargo::create([
            'personas_id'    => $personas->get(0)->id,
            'cargos_id'      => $cargoDirector->id,
            'sit_revista_id' => $sitTitular->id,
        ]);


        if ($personas->has(1)) {
            PersonaCargo::create([
                'personas_id'    => $personas->get(1)->id,
                'cargos_id'      => $cargoSecretario->id,
                'sit_revista_id' => $sitInterino->id,
            ]);
        }


        foreach ($personas->slice(2) as $index => $persona) {

            if ($index % 2 == 0) {
                $cargoId = $cargoPreceptor->id;
                $revistaId = $sitTitular->id;
            } else {
                $cargoId = $cargoVicedirector->id;
                $revistaId = ($index % 3 == 0) ? $sitSuplente->id : $sitInterino->id;
            }

            PersonaCargo::create([
                'personas_id'    => $persona->id,
                'cargos_id'      => $cargoId,
                'sit_revista_id' => $revistaId,
            ]);
        }
    }
}
