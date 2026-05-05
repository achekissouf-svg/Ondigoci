<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $fillable = [
        'boutique_id',
        'moyen_paiement',
        'type_abonnement',
        'montant',
        'reference',
        'capture_ecran',
        'statut'
    ];

    public function boutique()
    {
        return $this->belongsTo(Boutique::class);
    }
}
