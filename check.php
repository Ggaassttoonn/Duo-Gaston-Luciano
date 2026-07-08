<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::capture();
$response = $kernel->handle($request);

$planillas = App\Models\Planilla::all();
echo "Planillas: " . $planillas->count() . "\n";
foreach ($planillas as $p) {
    echo "ID: {$p->id} user_id:{$p->user_id} titulo:{$p->titulo} estado:{$p->estado}\n";
}
echo "\nUsuarios:\n";
foreach (App\Models\Users::all() as $u) {
    echo "ID: {$u->id} name:{$u->name} email:{$u->email} role:{$u->role}\n";
}
