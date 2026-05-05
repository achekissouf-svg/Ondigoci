<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Boutique extends Model
{
    protected $fillable = [
        'user_id', 'nom_boutique', 'description', 'statut', 'logo', 
        'adresse_siege', 'whatsapp', 'type_abonnement', 'priorite',
        'piece_identite', 'justificatif_domicile', 'statut_verification', 'motif_rejet'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function produits()
    {
        return $this->hasMany(Produit::class, 'boutique_id');
    }

    public function promotions()
    {
        return $this->hasMany(Promotion::class, 'boutique_id');
    }

    public function avis()
    {
        return $this->hasMany(AvisBoutique::class, 'boutique_id');
    }

    public function getNoteMoyenneAttribute()
    {
        $avg = $this->avis()->avg('note');
        return $avg ? round($avg, 1) : 0;
    }

    public function getMaxProduits()
    {
        return match ($this->type_abonnement) {
            'gratuit' => 5,
            'standard' => 20,
            'premium' => null, // Unlimited
            default => 5,
        };
    }

    public function getMaxCategories()
    {
        return match ($this->type_abonnement) {
            'gratuit' => 1,
            'standard' => 3,
            'premium' => null, // Unlimited
            default => 1,
        };
    }

    public function aAtteintLimiteProduits()
    {
        $max = $this->getMaxProduits();
        if ($max === null) return false;
        return $this->produits()->count() >= $max;
    }

    public function aAtteintLimiteCategories($nouvelle_id_categorie)
    {
        $max = $this->getMaxCategories();
        if ($max === null) return false;

        $categories_utilisees = $this->produits()->distinct()->pluck('id_categorie')->toArray();
        
        if (in_array($nouvelle_id_categorie, $categories_utilisees)) {
            return false;
        }

        return count($categories_utilisees) >= $max;
    }
}
