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
            $table->string('piece_identite')->nullable()->after('logo');
            $table->string('justificatif_domicile')->nullable()->after('piece_identite');
            $table->enum('statut_verification', ['non_verifie', 'en_attente', 'approuve', 'rejete'])->default('non_verifie')->after('justificatif_domicile');
            $table->text('motif_rejet')->nullable()->after('statut_verification');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('boutiques', function (Blueprint $table) {
            $table->dropColumn(['piece_identite', 'justificatif_domicile', 'statut_verification', 'motif_rejet']);
        });
    }

};
