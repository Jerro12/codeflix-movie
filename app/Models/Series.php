<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Series extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'poster',
        'banner',
        'director',
        'cast',
        'release_year',
        'status',
        'age_rating',
    ];

    protected $casts = [
        'release_year' => 'integer',
    ];

    /**
     * Get all seasons for this series.
     */
    public function seasons(): HasMany
    {
        return $this->hasMany(Season::class)->orderBy('number');
    }

    /**
     * Get all episodes across all seasons.
     */
    public function episodes()
    {
        return $this->hasManyThrough(Episode::class, Season::class);
    }

    /**
     * Get categories for this series.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'series_category');
    }

    /**
     * Get total episode count.
     */
    public function getTotalEpisodesAttribute(): int
    {
        return $this->episodes()->count();
    }

    /**
     * Get status badge class.
     */
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'ongoing' => 'bg-codeflix-primary',
            'completed' => 'bg-green-500',
            'cancelled' => 'bg-red-500',
            default => 'bg-gray-500',
        };
    }
}
