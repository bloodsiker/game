<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = [
        'name', 'short_name', 'code', 'accuracy', 'icon', 'is_active', 'position'
    ];
}
