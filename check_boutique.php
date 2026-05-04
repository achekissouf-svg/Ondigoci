<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Boutique;

$b = Boutique::first();
if ($b) {
    echo "Boutique: " . $b->nom_boutique . "\n";
    echo "Type Abonnement: " . $b->type_abonnement . "\n";
    echo "Max Produits: " . $b->getMaxProduits() . "\n";
    echo "Current Produits: " . $b->produits()->count() . "\n";
    echo "Statut: " . $b->statut . "\n";
} else {
    echo "No boutique found\n";
}
