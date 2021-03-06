<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Terrain extends Model
{
    protected $hidden = [
        'id'
    ];

    public function dump(): HasOne
    {
        return $this->HasOne(Dump::class);
    }
}
