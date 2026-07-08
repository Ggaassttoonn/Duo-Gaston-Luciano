<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Users;
use App\Models\Planilla;

class PlanillaTestSeeder extends Seeder
{
    public function run(): void
    {
        $user = Users::first();

        if (!$user) {
            $this->command->warn('No hay usuarios. Ejecutá UsersSeeder primero.');
            return;
        }

        $estados = ['borrador', 'pendiente', 'revisado', 'aprobado', 'rechazado'];

        foreach ($estados as $i => $estado) {
            Planilla::create([
                'titulo'   => "Planilla de prueba " . ($i + 1),
                'contenido' => "Contenido de la planilla de prueba número " . ($i + 1) . ".",
                'user_id'  => $user->id,
                'estado'   => $estado,
            ]);
        }

        $this->command->info("Creadas 5 planillas de prueba para {$user->name}.");
    }
}
