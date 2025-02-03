<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RetroBoard extends Model
{
    protected $fillable = [
        'token',
        'is_saved',
    ];

    public function items()
    {
        return $this->hasMany(RetroItem::class);
    }
}
