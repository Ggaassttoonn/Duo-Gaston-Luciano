<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::capture();
$response = $kernel->handle($request);

echo "=== PLANILLA_DESTINATARIOS ===\n";
foreach (App\Models\PlanillaDestinatario::all() as $d) {
    echo "ID: {$d->id} planilla_id:{$d->planilla_id} director_id:{$d->director_id}\n";
}

echo "\n=== USUARIOS ===\n";
foreach (App\Models\Users::all() as $u) {
    echo "ID: {$u->id} name:{$u->name} role:{$u->role}\n";
}
