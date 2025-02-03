<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RetroItem extends Model
{
    protected $fillable = ['retro_board_id', 'category', 'content', 'vote_count'];

    public function board()
    {
        return $this->belongsTo(RetroBoard::class, 'retro_board_id');
    }
}
