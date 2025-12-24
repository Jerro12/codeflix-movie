<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Season extends Model
{
    protected $fillable = [
        'series_id',
        'number',
        'title',
        'release_date',
    ];

    protected $casts = [
        'release_date' => 'date',
    ];

    /**
     * Get the series this season belongs to.
     */
    public function series(): BelongsTo
    {
        return $this->belongsTo(Series::class);
    }

    /**
     * Get all episodes in this season.
     */
    public function episodes(): HasMany
    {
        return $this->hasMany(Episode::class)->orderBy('number');
    }

    /**
     * Get season title or formatted number.
     */
    public function getDisplayTitleAttribute(): string
    {
        return $this->title ?? "Season {$this->number}";
    }
}
