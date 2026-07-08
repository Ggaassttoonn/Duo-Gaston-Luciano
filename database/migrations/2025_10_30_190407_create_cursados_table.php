<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cursados', function (Blueprint $table) {
            $table->id();
            $table->string('anio_lectivo', 40);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('restrict');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cursados');
    }
};
