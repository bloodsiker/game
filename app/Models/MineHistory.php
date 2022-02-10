<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MineHistory extends Model
{
    protected $hidden = ['created_at', 'updated_at'];

    public $timestamps = false;

    protected $fillable = [
        'sum', 'count_mine', 'coeff', 'won_sum', 'active', 'lose', 'mines', 'revealed', 'step', 'time_game'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
