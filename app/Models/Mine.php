<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mine extends Model
{
    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = [
        'sum', 'count_mine', 'coeff', 'won_sum', 'active', 'lose', 'mines', 'revealed', 'step'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
