<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    protected $primaryKey = 'id_commande';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'id_commande', 'num_commande', 'date_commande', 'montant_total_commande',
        'statut_commande', 'id_mode_paiement', 'user_id'
    ];
    
    protected $casts = [
        'date_commande' => 'date',
    ];
    
    public function modePaiement()
    {
        return $this->belongsTo(ModePaiement::class, 'id_mode_paiement');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function ligneCommandes()
    {
        return $this->hasMany(LigneCommande::class, 'id_commande');
    }
    
    public function livraison()
    {
        return $this->hasOne(Livraison::class, 'id_commande');
    }
}