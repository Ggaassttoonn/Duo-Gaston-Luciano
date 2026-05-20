<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RevistaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sit_revista')->insert([
            ['revista' => 'Titular'],
            ['revista' => 'interino'],
            ['revista' => 'suplente']
        ]);
    }

    public function down()
    {
        DB::table('sit_revista')->truncate();
    }
}
