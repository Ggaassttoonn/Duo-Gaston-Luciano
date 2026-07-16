<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE assignments DROP CONSTRAINT IF EXISTS assignments_user_id_foreign');
        Schema::table('assignments', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE assignments DROP CONSTRAINT IF EXISTS assignments_user_id_foreign');
        Schema::table('assignments', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });
    }
};
