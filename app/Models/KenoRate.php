<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KenoRate extends Model
{
    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = [
        'number', 'count_win', 'coeff', 'type'
    ];
}
