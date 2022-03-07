<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoinFlipHistory extends Model
{
    protected $table = 'coinflip_histories';

    protected $hidden = ['created_at', 'updated_at'];

    public $timestamps = false;

    protected $fillable = [
        'user_id', 'currency_id', 'bet', 'coeff', 'won_sum', 'active', 'lose', 'coins', 'revealed', 'step', 'time_game', 'profit', 'remainder'
    ];

    protected $dates = ['time_game'];

    public function currency()
    {
        return $this->hasOne(Currency::class, 'id', 'currency_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }
}
