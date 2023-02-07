<?php

namespace App\Models;

use App\Services\StrHelperService;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ref_id', 'ref_link', 'login', 'email', 'password',
    ];

    protected $balance;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getBalance($currency)
    {
        switch ($currency) {
            case 'btc':
                return $this->btc;
            case 'usd':
                return $this->usd;
            case 'rub':
                return $this->rub;
            case 'uah':
                return $this->uah;
            default:
                return 0;
        }
    }

    /**
     * @param $currency
     *
     * @return $this
     */
    public function setActiveBalance($currency)
    {
        $this->balance = $currency;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getActiveBalance()
    {
        return $this->{$this->balance};
    }

    public function addToBalance($amount, $accuracy = 8)
    {
        $balance = bcadd(StrHelperService::numberFormat($this->{$this->balance}), StrHelperService::numberFormat($amount), $accuracy);
        $this->{$this->balance} = $balance;
        $this->save();
    }

    public function writeOffBalance($amount, $accuracy = 8)
    {
        $balance = bcsub(StrHelperService::numberFormat($this->{$this->balance}), StrHelperService::numberFormat($amount), $accuracy);
        $this->{$this->balance} = $balance;
        $this->save();
    }
}
