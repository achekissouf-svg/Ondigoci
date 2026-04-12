<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LigneCommande extends Model
{
    protected $primaryKey = 'id_ligne_commande';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'id_ligne_commande', 'id_produit', 'id_commande', 'quantite_ligne_commande', 'prix_au_moment_achat'
    ];
    
    public function produit()
    {
        return $this->belongsTo(Produit::class, 'id_produit');
    }
    
    public function commande()
    {
        return $this->belongsTo(Commande::class, 'id_commande');
    }
}