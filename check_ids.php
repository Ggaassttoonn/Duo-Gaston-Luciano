<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::capture();
$response = $kernel->handle($request);
foreach (App\Models\Users::all() as $u) {
    echo 'ID: ' . $u->id . ' | persona_id: ' . $u->persona_id . ' | name: ' . $u->name . ' | role: ' . $u->role . PHP_EOL;
}
