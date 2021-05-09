<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MineRate extends Model
{
    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = [
        'mine', 'coff', 'step'
    ];
}
