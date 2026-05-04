<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Produit;

$produits = Produit::all();
echo "Total Products: " . $produits->count() . "\n";
foreach ($produits as $p) {
    echo "- ID: " . $p->id_produit . " | Nom: " . $p->nom_produit . " | Boutique: " . $p->boutique_id . "\n";
}
