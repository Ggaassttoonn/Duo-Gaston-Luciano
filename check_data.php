<?php
require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== PLANILLAS ===\n";
$planillas = App\Models\Planilla::all();
echo 'Total: ' . $planillas->count() . "\n";
foreach ($planillas as $p) {
    echo "ID: {$p->id} | user_id: {$p->user_id} | titulo: {$p->titulo} | estado: {$p->estado}\n";
}

echo "\n=== USUARIOS ===\n";
foreach (App\Models\Users::all() as $u) {
    echo "ID: {$u->id} | name: {$u->name} | email: {$u->email} | role: {$u->role}\n";
}
