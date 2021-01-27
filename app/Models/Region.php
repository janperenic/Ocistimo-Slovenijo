<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Region extends Model
{

    public function location(): HasOne
    {
        return $this->hasOne(Location::class);
    }
}
