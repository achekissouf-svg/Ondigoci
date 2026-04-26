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
        Schema::table('boutiques', function (Blueprint $table) {
            $table->enum('type_abonnement', ['gratuit', 'standard', 'premium'])->default('gratuit')->after('statut');
            $table->integer('priorite')->default(0)->after('type_abonnement');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('boutiques', function (Blueprint $table) {
            $table->dropColumn(['type_abonnement', 'priorite']);
        });
    }
};
