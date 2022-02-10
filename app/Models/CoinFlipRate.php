<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoinFlipRate extends Model
{
    protected $table = 'coinflip_rates';

    public $timestamps = false;

    protected $dates = ['time_game'];

    protected $fillable = [
        'step', 'coeff', 'finish'
    ];
}
