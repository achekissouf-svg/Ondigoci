<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mode_paiements', function (Blueprint $table) {
            $table->string('id_mode_paiement', 50)->primary();
            $table->string('libel_mode_paiement', 50);
            $table->string('description_mode_paiement', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mode_paiements');
    }
};