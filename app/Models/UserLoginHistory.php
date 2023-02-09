<?php

namespace App\Models;

use App\Services\StrHelperService;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserLoginHistory extends Authenticatable
{
    use HasFactory;

    protected $table = 'user_login_histories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'ip', 'user_agent'
    ];
}
