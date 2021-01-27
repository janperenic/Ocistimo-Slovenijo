<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    public $timestamps = ['created_at'];

    protected $hidden = ['dump_id', 'deleted_at', 'id'];

    public function dump(): BelongsTo
    {
        return $this->belongsTo(Dump::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}