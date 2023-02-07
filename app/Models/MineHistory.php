<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MineHistory extends Model
{
    protected $fillable = [
        'sum', 'count_mine', 'coeff', 'won_sum', 'active', 'lose', 'mines', 'revealed', 'step', 'profit', 'remainder', 'time_game'
    ];

    public $timestamps = false;

    protected $hidden = ['created_at', 'updated_at'];

    protected $dates = ['time_game'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function currency()
    {
        return $this->hasOne(Currency::class, 'id', 'currency_id');
    }
}
