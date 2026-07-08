<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::capture();
$response = $kernel->handle($request);

echo "=== NOTIFICACIONES ===\n";
foreach (App\Models\Notification::all() as $n) {
    echo "ID: {$n->id} user_id:{$n->user_id} type:{$n->type} title:{$n->title} planilla_id:{$n->planilla_id} read:{$n->read}\n";
}

echo "\n=== PLANILLA_DESTINATARIOS ===\n";
foreach (App\Models\PlanillaDestinatario::all() as $d) {
    echo "ID: {$d->id} planilla_id:{$d->planilla_id} director_id:{$d->director_id}\n";
}

echo "\n=== PLANILLA 17 DESTINATARIOS ===\n";
$p = App\Models\Planilla::with('destinatarios.director')->find(17);
if ($p) {
    echo "Titulo: {$p->titulo}\n";
    echo "Destinatarios: " . $p->destinatarios->count() . "\n";
    foreach ($p->destinatarios as $d) {
        echo "  Director ID: {$d->director_id} Nombre: {$d->director->name}\n";
    }
}
