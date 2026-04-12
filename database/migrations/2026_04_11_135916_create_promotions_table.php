<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->string('id_promo', 50)->primary();
            $table->string('nom_promo', 100);
            $table->decimal('pourcentage_reduction', 5, 2);
            $table->date('date_debut_promo');
            $table->date('date_fin_promo');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};