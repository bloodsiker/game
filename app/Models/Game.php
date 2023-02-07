<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = [
        'name', 'slug', 'edge', 'max_win', 'min_bid', 'is_active'
    ];
}
