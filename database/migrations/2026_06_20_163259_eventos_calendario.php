<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('eventos_calendario', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->enum('tipo', ['capacitacion', 'acto', 'feriado', 'reunion', 'taller']);
            $table->date('fecha');
            $table->time('hora')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('autor_nombre')->nullable();
            $table->string('autor_rol')->nullable();
            $table->foreignId('persona_id')->nullable()->constrained('personas')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eventos_calendario');
    }
};
