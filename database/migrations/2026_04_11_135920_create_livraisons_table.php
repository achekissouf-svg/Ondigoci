<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('livraisons', function (Blueprint $table) {
            $table->string('id_livraison', 50)->primary();
            $table->string('adresse_livraison', 255);
            $table->dateTime('date_estimee');
            $table->decimal('frais_livraison', 10, 2);
            $table->string('statut_livraison', 30)->default('en_attente');
            $table->string('id_commande', 50);
            $table->timestamps();
            
            $table->foreign('id_commande')->references('id_commande')->on('commandes')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('livraisons');
    }
};