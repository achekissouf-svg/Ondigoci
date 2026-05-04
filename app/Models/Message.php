<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Message extends Model
{
    protected $primaryKey = 'id_message';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_message', 'sender_id', 'receiver_id', 'content', 'is_read'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id_message)) {
                $model->id_message = (string) Str::uuid();
            }
        });
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
