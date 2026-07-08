<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Curso;
use App\Models\Cursado;
use PhpParser\Node\Stmt\Foreach_;

class CursadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cursos = Curso::all();

        if ($cursos->isEmpty()) {
            return;
        }
        $anioLectivo = '2026';
        $inicioClases = '2026-03-02';
        $finClases = '2026-12-18';

        foreach ($cursos as $curso) {
            Cursado::create([
                'anio_lectivo' => $anioLectivo,
                'fecha_inicio' => $inicioClases,
                'fecha_fin' => $finClases,
                'curso_id' => $curso->id,

            ]);
        }
    }
}
