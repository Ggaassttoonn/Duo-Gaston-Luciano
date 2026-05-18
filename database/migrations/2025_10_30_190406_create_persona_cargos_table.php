<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('persona_cargos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personas_id')->constrained('personas')->onDelete('cascade');
            $table->foreignId('cargos_id')->constrained('cargos')->onDelete('cascade');
            $table->foreignId('sit_revista_id')->constrained('sit_revista')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('persona_cargos');
    }
};
