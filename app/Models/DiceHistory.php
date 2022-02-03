<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiceHistory extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'currency_id', 'under_over', 'bet', 'profit', 'multiplier', 'roll', 'remainder', 'target', 'time_game'
    ];

    protected $dates = ['time_game'];

    public function currency()
    {
        return $this->hasOne(Currency::class, 'id', 'currency_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
