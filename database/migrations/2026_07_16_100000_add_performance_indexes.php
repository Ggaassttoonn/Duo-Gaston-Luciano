<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('planillas', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('estado');
        });

        Schema::table('planilla_destinatarios', function (Blueprint $table) {
            $table->index('director_id');
        });

        Schema::table('planificacion_diaria', function (Blueprint $table) {
            $table->index('persona_cargo_cursado_id');
            $table->index('fecha_estimada');
            $table->index('fecha_presentacion');
        });

        Schema::table('planificacion_anual', function (Blueprint $table) {
            $table->index('persona_cargo_cursado_id');
            $table->index('area_id');
            $table->index('fecha_presentacion');
        });

        Schema::table('estados_diaria', function (Blueprint $table) {
            $table->index('planificacion_diaria_id');
        });

        Schema::table('estados_anual', function (Blueprint $table) {
            $table->index('planificacion_anual_id');
        });

        Schema::table('assignments', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('deadline_id');
        });

        Schema::table('deadlines', function (Blueprint $table) {
            $table->index('director_id');
            $table->index('fecha_limite');
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('type');
        });

        Schema::table('persona_cargo_cursado', function (Blueprint $table) {
            $table->index('persona_cargos_id');
            $table->index('cursado_id');
        });

        Schema::table('persona_cargos', function (Blueprint $table) {
            $table->index('persona_id');
            $table->index('cargo_id');
        });

        Schema::table('cursados', function (Blueprint $table) {
            $table->index('curso_id');
        });
    }

    public function down(): void
    {
        Schema::table('planillas', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'estado']);
        });

        Schema::table('planilla_destinatarios', function (Blueprint $table) {
            $table->dropIndex(['director_id']);
        });

        Schema::table('planificacion_diaria', function (Blueprint $table) {
            $table->dropIndex(['persona_cargo_cursado_id', 'fecha_estimada', 'fecha_presentacion']);
        });

        Schema::table('planificacion_anual', function (Blueprint $table) {
            $table->dropIndex(['persona_cargo_cursado_id', 'area_id', 'fecha_presentacion']);
        });

        Schema::table('estados_diaria', function (Blueprint $table) {
            $table->dropIndex(['planificacion_diaria_id']);
        });

        Schema::table('estados_anual', function (Blueprint $table) {
            $table->dropIndex(['planificacion_anual_id']);
        });

        Schema::table('assignments', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'deadline_id']);
        });

        Schema::table('deadlines', function (Blueprint $table) {
            $table->dropIndex(['director_id', 'fecha_limite']);
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'type']);
        });

        Schema::table('persona_cargo_cursado', function (Blueprint $table) {
            $table->dropIndex(['persona_cargos_id', 'cursado_id']);
        });

        Schema::table('persona_cargos', function (Blueprint $table) {
            $table->dropIndex(['persona_id', 'cargo_id']);
        });

        Schema::table('cursados', function (Blueprint $table) {
            $table->dropIndex(['curso_id']);
        });
    }
};
