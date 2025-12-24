<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WatchHistory extends Model
{
    protected $fillable = [
        'user_id',
        'movie_id',
        'progress_seconds',
        'duration_seconds',
        'completed',
        'last_watched_at',
    ];

    protected $casts = [
        'completed' => 'boolean',
        'last_watched_at' => 'datetime',
    ];

    /**
     * Get the user that owns the watch history entry.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the movie in the watch history.
     */
    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

    /**
     * Get the progress percentage.
     */
    public function getProgressPercentageAttribute(): float
    {
        if ($this->duration_seconds <= 0) {
            return 0;
        }

        return round(($this->progress_seconds / $this->duration_seconds) * 100, 1);
    }

    /**
     * Check if the movie is completed (watched more than 90%).
     */
    public function isAlmostCompleted(): bool
    {
        return $this->progress_percentage >= 90;
    }
}
