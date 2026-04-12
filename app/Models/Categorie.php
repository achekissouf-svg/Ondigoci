<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $primaryKey = 'id_categorie';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'id_categorie', 'libel_categorie', 'image_categorie', 'slug_categorie'
    ];
    
    public function produits()
    {
        return $this->hasMany(Produit::class, 'id_categorie');
    }
}