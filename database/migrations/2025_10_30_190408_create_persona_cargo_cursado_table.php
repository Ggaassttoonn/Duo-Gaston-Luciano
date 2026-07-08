<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('persona_cargo_cursado', function (Blueprint $table) {
            $table->id();
            $table->foreignId('persona_cargos_id')->constrained('persona_cargos')->onDelete('cascade');
            $table->foreignId('cursado_id')->constrained('cursados')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('persona_cargo_cursado');
    }
};
