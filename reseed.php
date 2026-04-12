<?php
use App\Models\User;
use App\Models\Boutique;
use App\Models\Categorie;
use App\Models\ModePaiement;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

DB::statement('SET FOREIGN_KEY_CHECKS=0;');
User::truncate();
Boutique::truncate();
Categorie::truncate();
ModePaiement::truncate();
DB::statement('SET FOREIGN_KEY_CHECKS=1;');

$admin = User::create([
    'name' => 'Admin Ondigoci',
    'email' => 'admin@ondigoci.test',
    'password' => Hash::make('password'),
    'role' => 'admin',
    'statut' => 'actif',
]);

Boutique::create([
    'user_id' => $admin->id,
    'nom_boutique' => 'Ondigoci Direct',
    'description' => 'Boutique officielle de l\'administration Ondigoci.',
    'statut' => 'approuve',
    'adresse_siege' => 'Siège Social Ondigoci'
]);

User::create([
    'name' => 'Client Test',
    'email' => 'client@ondigoci.test',
    'password' => Hash::make('password'),
    'role' => 'client',
    'statut' => 'actif',
]);

Categorie::create(['id_categorie' => 'CAT001', 'libel_categorie' => 'Électronique', 'slug_categorie' => 'electronique']);
ModePaiement::create(['id_mode_paiement' => 'MP001', 'libelle_mode_paiement' => 'Cash à la livraison']);

echo "Database seeded successfully!\n";
