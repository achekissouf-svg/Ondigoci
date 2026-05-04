<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('avis_produits', function (Blueprint $table) {
            $table->id();
            $table->string('id_produit', 50);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('note');
            $table->text('commentaire')->nullable();
            $table->timestamps();

            $table->foreign('id_produit')->references('id_produit')->on('produits')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('avis_produits');
    }
};
