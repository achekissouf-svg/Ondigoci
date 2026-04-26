<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Insérer les nouvelles données sans supprimer les anciennes pour éviter l'erreur de contrainte
        DB::table('mode_paiements')->insertOrIgnore([
            ['id_mode_paiement' => 'MP_MOBILE', 'libel_mode_paiement' => 'Mobile Money (Orange, MTN, Moov, Wave)'],
            ['id_mode_paiement' => 'MP_LIVRAISON', 'libel_mode_paiement' => 'Paiement à la livraison'],
            ['id_mode_paiement' => 'MP_PLACE', 'libel_mode_paiement' => 'Paiement sur place'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
