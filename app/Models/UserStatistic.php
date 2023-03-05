<?php

namespace App\Models;

use App\Services\StrHelperService;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserStatistic extends Authenticatable
{
    use HasFactory;

    protected $table = 'user_statistics';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'currency_id', 'wagered', 'profit', 'dice', 'mines', 'coinflip', 'keno', 'cards'
    ];

    public $timestamps = false;

    public function currency()
    {
        return $this->hasOne(Currency::class, 'id', 'currency_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
