<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('planilla_revisions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('planilla_id');
            $table->foreignId('director_id')->constrained('users')->onDelete('cascade');
            $table->string('estado');
            $table->text('comentario')->nullable();
            $table->text('audio_base64')->nullable();
            $table->string('audio_mime')->nullable();
            $table->unsignedBigInteger('planilla_original_id')->nullable();
            $table->timestamps();

            $table->foreign('planilla_id')->references('id')->on('planillas')->onDelete('cascade');
            $table->unique(['planilla_id', 'director_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('planilla_revisions');
    }
};
