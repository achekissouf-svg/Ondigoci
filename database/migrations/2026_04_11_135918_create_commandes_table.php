<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->string('id_commande', 50)->primary();
            $table->string('num_commande', 50)->unique();
            $table->date('date_commande');
            $table->decimal('montant_total_commande', 10, 2);
            $table->string('statut_commande', 30)->default('en_attente');
            $table->string('id_mode_paiement', 50);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            $table->foreign('id_mode_paiement')->references('id_mode_paiement')->on('mode_paiements');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};