<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('planificacion_diaria', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_estimada');
            $table->date('fecha_desarrollada');
            $table->date('fecha_presentacion');
            $table->longText('contenidos_especificos');
            $table->longText('actividades');
            $table->longText('tareas');
            $table->foreignId('persona_cargo_cursado_id')->constrained('persona_cargo_cursado')->onDelete('cascade');
            $table->string('tipo_planificacion', 45);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('planificacion_diaria');
    }
};
