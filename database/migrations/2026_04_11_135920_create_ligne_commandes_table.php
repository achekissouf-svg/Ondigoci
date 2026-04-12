<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ligne_commandes', function (Blueprint $table) {
            $table->string('id_ligne_commande', 50)->primary();
            $table->string('id_produit', 50);
            $table->string('id_commande', 50);
            $table->integer('quantite_ligne_commande');
            $table->decimal('prix_au_moment_achat', 10, 2);
            $table->timestamps();
            
            $table->foreign('id_produit')->references('id_produit')->on('produits');
            $table->foreign('id_commande')->references('id_commande')->on('commandes')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ligne_commandes');
    }
};