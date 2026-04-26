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
        Schema::create('avis_boutiques', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('boutique_id')->constrained('boutiques')->onDelete('cascade');
            $table->tinyInteger('note')->unsigned(); // 1 to 5
            $table->text('commentaire')->nullable();
            $table->timestamps();
            
            // Un utilisateur ne peut laisser qu'un seul avis par boutique
            $table->unique(['user_id', 'boutique_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avis_boutiques');
    }
};
