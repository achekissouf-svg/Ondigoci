<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Produit;
use App\Models\Boutique;
use Illuminate\Support\Str;

$b = Boutique::first();
if (!$b) {
    echo "No boutique found\n";
    exit;
}

echo "Boutique: " . $b->nom_boutique . " (ID: " . $b->id . ")\n";

try {
    Produit::create([
        'id_produit' => Str::uuid(),
        'nom_produit' => 'Test 1 ' . time(),
        'description_produit' => 'Desc',
        'prix_unitaire_produit' => 100,
        'stock_disponible_produit' => 10,
        'image_principale_produit' => 'img.png',
        'id_categorie' => 'CAT001',
        'boutique_id' => $b->id
    ]);
    echo "Product 1 created\n";
    
    Produit::create([
        'id_produit' => Str::uuid(),
        'nom_produit' => 'Test 2 ' . time(),
        'description_produit' => 'Desc',
        'prix_unitaire_produit' => 200,
        'stock_disponible_produit' => 20,
        'image_principale_produit' => 'img.png',
        'id_categorie' => 'CAT001',
        'boutique_id' => $b->id
    ]);
    echo "Product 2 created\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "Total Products: " . Produit::count() . "\n";
