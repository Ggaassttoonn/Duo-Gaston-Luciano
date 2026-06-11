<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('planilla_destinatarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('planilla_id');
            $table->unsignedBigInteger('director_id');
            $table->text('comentario')->nullable();
            $table->string('audio')->nullable();
            $table->boolean('leido')->default(false);
            $table->timestamps();

            $table->foreign('planilla_id')->references('id')->on('planillas')->onDelete('cascade');
            $table->foreign('director_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('planilla_destinatarios');
    }
};
