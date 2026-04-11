<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historique extends Model
{
    protected $primaryKey = 'id_historique';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'id_historique', 'action_effectuee', 'date_action_historique', 'user_id'
    ];
    
    protected $casts = [
        'date_action_historique' => 'datetime',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}