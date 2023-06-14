<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MineSetting extends Model
{
    protected $table = 'mine_settings';

    public $timestamps = false;

    protected $fillable = [
       'currency_id', 'edge', 'max_win', 'min_bid', 'min_mines', 'max_mines'
    ];

    public function currency()
    {
        return $this->hasOne(Currency::class, 'id', 'currency_id');
    }
}
