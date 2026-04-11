<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Panier extends Model
{
    protected $primaryKey = 'id_panier';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'id_panier', 'id_produit', 'user_id', 'quantite'
    ];
    
    public function produit()
    {
        return $this->belongsTo(Produit::class, 'id_produit');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}