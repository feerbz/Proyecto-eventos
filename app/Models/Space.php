<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Space extends Model
{
    protected $fillable = [
        'name',
        'capacity',
        'is_unlimited',
        'map',
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}

