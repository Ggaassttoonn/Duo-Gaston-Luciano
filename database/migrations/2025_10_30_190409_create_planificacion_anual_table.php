<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('planificacion_anual', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_presentacion');
            $table->longText('aprendizajes_esperados');
            $table->longText('saberes');
            $table->longText('criterios');
            $table->longText('bibliografia');
            $table->longText('diagnostico');
            $table->foreignId('area_id')->constrained('areas')->onDelete('cascade');
            $table->foreignId('persona_cargo_cursado_id')->constrained('persona_cargo_cursado')->onDelete('cascade');
            $table->string('tipo_planificacion');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('planificacion_anual');
    }
};
