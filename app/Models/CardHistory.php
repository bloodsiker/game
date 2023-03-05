<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CardHistory extends Model
{
    protected $table = 'cards_histories';

    protected $hidden = ['created_at', 'updated_at'];

    public $timestamps = false;

    protected $fillable = [
        'user_id', 'currency_id', 'sum', 'extra_sum', 'is_extra', 'coeff', 'won_sum', 'min_won_sum', 'active',
        'lose', 'attempts', 'cards', 'revealed', 'time_game', 'profit', 'remainder'
    ];

    protected $dates = ['time_game'];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
