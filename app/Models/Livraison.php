<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Livraison extends Model
{
    protected $primaryKey = 'id_livraison';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'id_livraison', 'adresse_livraison', 'date_estimee', 'frais_livraison', 'statut_livraison', 'id_commande'
    ];
    
    protected $casts = [
        'date_estimee' => 'datetime',
    ];
    
    public function commande()
    {
        return $this->belongsTo(Commande::class, 'id_commande');
    }
}