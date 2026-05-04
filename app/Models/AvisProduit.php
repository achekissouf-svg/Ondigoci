<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvisProduit extends Model
{
    protected $table = 'avis_produits';
    protected $fillable = ['id_produit', 'user_id', 'note', 'commentaire'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'id_produit', 'id_produit');
    }}
