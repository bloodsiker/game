<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameHistory extends Model
{
    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = [
        'sum', 'coff', 'result'
    ];

    public function game()
    {
        return $this->hasOne(Game::class, 'id', 'game_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
