<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModePaiement extends Model
{
    protected $primaryKey = 'id_mode_paiement';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'id_mode_paiement', 'libel_mode_paiement', 'description_mode_paiement'
    ];
    
    public function commandes()
    {
        return $this->hasMany(Commande::class, 'id_mode_paiement');
    }
}