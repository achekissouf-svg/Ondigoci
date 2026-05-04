<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Boutique;

foreach (Boutique::all() as $b) {
    echo "Boutique " . $b->id . " (" . $b->nom_boutique . ") belongs to user " . $b->user_id . "\n";
}
