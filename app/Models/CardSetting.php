<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CardSetting extends Model
{
    protected $table = 'cards_settings';

    public $timestamps = false;

    protected $fillable = [
       'currency_id', 'edge', 'max_win', 'min_bid', 'min_ratio'
    ];

    public function currency()
    {
        return $this->hasOne(Currency::class, 'id', 'currency_id');
    }
}
