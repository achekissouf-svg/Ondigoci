<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entreprises', function (Blueprint $table) {
            $table->string('id_entreprise', 50)->primary();
            $table->string('nom_entreprise', 100);
            $table->string('description_entreprise', 100);
            $table->string('logo', 255)->nullable();
            $table->string('adresse_siege', 155);
            $table->boolean('est_active')->default(true);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entreprises');
    }
};