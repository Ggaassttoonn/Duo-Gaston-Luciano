<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('planilla_states', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('planilla_id');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('estado');
            $table->timestamps();

            $table->foreign('planilla_id')->references('id')->on('planillas')->onDelete('cascade');
            $table->unique(['planilla_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('planilla_states');
    }
};
