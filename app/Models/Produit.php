<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    protected $primaryKey = 'id_produit';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'id_produit', 'nom_produit', 'description_produit', 'prix_unitaire_produit',
        'stock_disponible_produit', 'image_principale_produit', 'id_promo', 'id_categorie', 'boutique_id'
    ];
    
    public function promotion()
    {
        return $this->belongsTo(Promotion::class, 'id_promo');
    }
    
    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'id_categorie');
    }
    
    public function boutique()
    {
        return $this->belongsTo(Boutique::class, 'boutique_id');
    }
    
    public function avis()
    {
        return $this->hasMany(AvisProduit::class, 'id_produit', 'id_produit');
    }

    public function getNoteMoyenneAttribute()
    {
        $avg = $this->avis()->avg('note');
        return $avg ? round($avg, 1) : 0;
    }

    public function prixAvecReduction()
    {
        if ($this->promotion && $this->promotion->date_debut_promo <= now() && $this->promotion->date_fin_promo >= now()) {
            return $this->prix_unitaire_produit * (1 - $this->promotion->pourcentage_reduction / 100);
        }
        return $this->prix_unitaire_produit;
    }
}