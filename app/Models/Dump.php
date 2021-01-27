<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;


class Dump extends Model
{
    use SoftDeletes;

    protected $hidden = [
        'user_id',
        'deleted_at',
        'volume_id',
        'terrain_id',
        'access_id',
        'irsop_id'
    ];

    protected $casts = [
        'dangerous' => 'boolean',
        'cleared' => 'boolean',
        'urgent' => 'boolean'
    ];

    public function location(): HasOne
    {
        return $this->hasOne(Location::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function trashType(): HasOne
    {
        return $this->HasOne(TrashType::class);
    }

    public function estimatedTrashVolume(): HasOne
    {
        return $this->hasOne(EstimatedTrashVolume::class);
    }

    public function coordinate(): HasOne
    {
        return $this->hasOne(Coordinate::class);
    }

    public function irsop(): BelongsTo
    {
        return $this->belongsTo(Irsop::class);
    }

    public function terrain(): BelongsTo
    {
        return $this->belongsTo(Terrain::class);
    }

    public function access(): BelongsTo
    {
        return $this->belongsTo(Access::class);
    }

    public function volume(): BelongsTo
    {
        return $this->belongsTo(Volume::class);
    }
}
