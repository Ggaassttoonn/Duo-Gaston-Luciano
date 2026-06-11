<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sent_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('director_id')->constrained('users')->onDelete('cascade');
            $table->unsignedBigInteger('planilla_id')->nullable();
            $table->foreignId('docente_id')->constrained('users')->onDelete('cascade');
            $table->text('comentario')->nullable();
            $table->text('audio_base64')->nullable();
            $table->string('audio_mime')->nullable();
            $table->timestamps();

            $table->foreign('planilla_id')->references('id')->on('planillas')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sent_reports');
    }
};
