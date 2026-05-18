<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estados_diaria', function (Blueprint $table) {
            $table->id();
            $table->string('estado', 45);
            $table->date('fecha');
            $table->foreignId('planificacion_diaria_id')->constrained('planificacion_diaria')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estados_diaria');
    }
};
