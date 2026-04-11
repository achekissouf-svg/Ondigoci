<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paniers', function (Blueprint $table) {
            $table->string('id_panier', 50)->primary();
            $table->string('id_produit', 50);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('quantite');
            $table->timestamps();
            
            $table->foreign('id_produit')->references('id_produit')->on('produits');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paniers');
    }
};
