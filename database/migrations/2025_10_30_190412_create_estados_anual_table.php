<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estados_anual', function (Blueprint $table) {
            $table->id();
            $table->string('estado', 45);
            $table->date('fecha');

            $table->foreignId('planificacion_anual_id')
                  ->constrained('planificacion_anual')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estados_anual');
    }
};
