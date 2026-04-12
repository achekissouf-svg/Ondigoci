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
        Schema::create('boutiques', function (Blueprint $table) {
            $table->id(); // Using numeric id for boutiques
            $table->string('nom_boutique', 100);
            $table->text('description')->nullable();
            $table->string('logo', 255)->nullable();
            $table->string('adresse_siege', 155)->nullable();
            $table->enum('statut', ['en_attente', 'approuve', 'rejete', 'bloque'])->default('en_attente');
            $table->foreignId('user_id')->Unique()->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boutiques');
    }
};
