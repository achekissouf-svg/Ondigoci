<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $primaryKey = 'id_promo';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'id_promo', 'nom_promo', 'pourcentage_reduction', 'date_debut_promo', 'date_fin_promo'
    ];
    
    protected $casts = [
        'date_debut_promo' => 'date',
        'date_fin_promo' => 'date',
    ];
    
    public function produits()
    {
        return $this->hasMany(Produit::class, 'id_promo');
    }
}