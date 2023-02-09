<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KenoHistory extends Model
{
    protected $hidden = ['created_at', 'updated_at'];

    public $timestamps = false;

    protected $fillable = [
        'user_id', 'currency_id', 'bet', 'type', 'profit', 'coeff', 'user_numbers', 'drop_numbers', 'win_numbers', 'remainder', 'time_game'
    ];

    protected $dates = ['time_game'];

    const TYPE_LOW    = 1;
    const TYPE_MEDIUM = 2;
    const TYPE_HIGH   = 3;

    public static $types = [
        self::TYPE_LOW => 'Low',
        self::TYPE_MEDIUM => 'Medium',
        self::TYPE_HIGH => 'High',
    ];

    public function currency()
    {
        return $this->hasOne(Currency::class, 'id', 'currency_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getTypeTextAttribute()
    {
        return self::$types[$this->type];
    }

    protected $appends = ['type_text'];
}
