<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Boutique extends Model
{
    protected $fillable = ['user_id', 'nom_boutique', 'description', 'statut', 'logo', 'adresse_siege'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function produits()
    {
        return $this->hasMany(Produit::class, 'boutique_id');
    }
}
