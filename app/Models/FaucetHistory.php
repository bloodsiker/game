<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaucetHistory extends Model
{
    const TYPE_F = 1;
    const TYPE_O = 2;

    protected $fillable = [
        'amount', 'date', 'description', 'type'
    ];

    public $timestamps = false;

    protected $dates = ['date'];

    public function currency()
    {
        return $this->hasOne(Currency::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
