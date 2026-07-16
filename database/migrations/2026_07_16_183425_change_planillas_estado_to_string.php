<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE planillas ALTER COLUMN estado TYPE varchar(50)');
        DB::statement('ALTER TABLE planillas DROP CONSTRAINT IF EXISTS planillas_estado_check');
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE planillas ALTER COLUMN estado TYPE varchar(50)");
    }
};
