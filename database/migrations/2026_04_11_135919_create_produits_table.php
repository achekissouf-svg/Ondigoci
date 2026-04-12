<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->string('id_produit', 50)->primary();
            $table->string('nom_produit', 150);
            $table->string('description_produit', 255);
            $table->decimal('prix_unitaire_produit', 10, 2);
            $table->integer('stock_disponible_produit');
            $table->string('image_principale_produit', 255);
            $table->string('id_promo', 50)->nullable();
            $table->string('id_categorie', 50);
            $table->foreignId('boutique_id')->constrained('boutiques')->onDelete('cascade');
            $table->timestamps();
            
            $table->foreign('id_promo')->references('id_promo')->on('promotions')->onDelete('set null');
            $table->foreign('id_categorie')->references('id_categorie')->on('categories');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};