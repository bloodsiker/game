<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KenoHistory extends Model
{
    protected $hidden = ['created_at', 'updated_at'];

    public $timestamps = false;

    protected $fillable = [
        'user_id', 'currency_id', 'bet', 'profit', 'coeff', 'user_numbers', 'drop_numbers', 'win_numbers', 'remainder', 'time_game'
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
