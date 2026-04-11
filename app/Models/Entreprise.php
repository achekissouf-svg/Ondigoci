<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    protected $primaryKey = 'id_entreprise';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'id_entreprise', 'nom_entreprise', 'description_entreprise', 'logo', 'adresse_siege', 'est_active', 'user_id'
    ];
    
    protected $casts = [
        'est_active' => 'boolean',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function produits()
    {
        return $this->hasMany(Produit::class, 'id_entreprise');
    }
}