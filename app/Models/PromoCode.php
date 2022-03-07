<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'quantity', 'discount', 'is_fixed_discount', 'start_date', 'end_date'
    ];

    protected $dates = ['start_date', 'end_date'];

    public function promo_code_activation()
    {
        return $this->hasMany(PromoCodeActive::class, 'promo_code_id', 'id');
    }

    public function currency()
    {
        return $this->hasOne(Currency::class, 'id', 'currency_id');
    }
}
