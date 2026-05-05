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
            $table->string('piece_identite_recto')->nullable()->after('logo');
            $table->string('piece_identite_verso')->nullable()->after('piece_identite_recto');
            $table->string('rccm')->nullable()->after('piece_identite_verso');
            $table->string('nom_responsable')->nullable()->after('nom_boutique');
            $table->string('photo_magasin')->nullable()->after('rccm');
            $table->string('lieu')->nullable()->after('photo_magasin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('boutiques', function (Blueprint $table) {
            //
        });
    }
};
