<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoCodeActive extends Model
{
    use HasFactory;

    protected $table = 'promo_code_active';

    protected $fillable = [
        'activation_date', 'promo_code_id', 'user_id'
    ];

    protected $dates = ['activation_date'];

    public function promo_code()
    {
        return $this->belongsTo(PromoCode::class, 'promo_code_id', 'id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
