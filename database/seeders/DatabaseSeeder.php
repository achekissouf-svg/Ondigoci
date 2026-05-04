<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Categorie;
use App\Models\Boutique;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Clear existing data to avoid duplicates
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        User::query()->delete();
        Boutique::query()->delete();
        Categorie::query()->delete();
        \App\Models\ModePaiement::query()->delete();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        // 0. Create Payment Modes (Global dependencies)
        \App\Models\ModePaiement::create(['id_mode_paiement' => 'MP001', 'libel_mode_paiement' => 'Cash à la livraison']);
        \App\Models\ModePaiement::create(['id_mode_paiement' => 'MP002', 'libel_mode_paiement' => 'Orange Money']);
        \App\Models\ModePaiement::create(['id_mode_paiement' => 'MP003', 'libel_mode_paiement' => 'MTN Mobile Money']);

        // 1. Create Categories
        $categories = [
            ['id_categorie' => 'CAT001', 'libel_categorie' => 'Électronique', 'slug_categorie' => 'electronique'],
            ['id_categorie' => 'CAT002', 'libel_categorie' => 'Mode', 'slug_categorie' => 'mode'],
            ['id_categorie' => 'CAT003', 'libel_categorie' => 'Maison', 'slug_categorie' => 'maison'],
            ['id_categorie' => 'CAT004', 'libel_categorie' => 'Beauté', 'slug_categorie' => 'beaute'],
        ];

        foreach ($categories as $cat) {
            Categorie::updateOrCreate(['id_categorie' => $cat['id_categorie']], $cat);
        }

        // 2. Create Admin User
        $admin = User::updateOrCreate(
            ['email' => 'admin@ondigoci.test'],
            [
                'name' => 'Admin Ondigoci',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'statut' => 'actif',
            ]
        );

        // 3. Create Admin's Boutique
        Boutique::updateOrCreate(
            ['user_id' => $admin->id],
            [
                'nom_boutique' => 'Ondigoci Direct',
                'description' => 'Boutique officielle de l\'administration Ondigoci.',
                'statut' => 'approuve',
                'adresse_siege' => 'Siège Social Ondigoci'
            ]
        );

        // 4. Create a test Boutique Seller
        $vendeur = User::updateOrCreate(
            ['email' => 'boutique@ondigoci.test'],
            [
                'name' => 'Boutique Test',
                'password' => Hash::make('password'),
                'role' => 'boutique',
                'statut' => 'actif',
            ]
        );

        Boutique::updateOrCreate(
            ['user_id' => $vendeur->id],
            [
                'nom_boutique' => 'Samsung Store',
                'description' => 'Produits technologiques de marque Samsung.',
                'statut' => 'approuve',
                'adresse_siege' => 'Akwa, Douala'
            ]
        );

        // 5. Create a test Client
        User::updateOrCreate(
            ['email' => 'client@ondigoci.test'],
            [
                'name' => 'Client Test',
                'password' => Hash::make('password'),
                'role' => 'client',
                'statut' => 'actif',
            ]
        );
    }
}
