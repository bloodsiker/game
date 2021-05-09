<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = [
        'name', 'is_active'
    ];

    public function network()
    {
        return $this->hasOne(Network::class, 'id', 'network_id');
    }
}
