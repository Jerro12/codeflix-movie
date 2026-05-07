<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'director',
        'writers',
        'stars',
        'cast',
        'poster',
        'trailer_url',
        'banner',
        'release_date',
        'duration',
        'rating',
        'age_rating',
        'video_url',
        'url_720',
        'url_1080',
        'url_4k',
        'category_id',
    ];

    protected $appends = [
        'average_rating',
    ];

    protected $casts = [
        'release_date' => 'date',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->latest();
    }

    /**
     * Accessor untuk atribut 'average_rating'.
     * Returns user ratings average, or falls back to seeded rating.
     *
     * @return float
     */
    public function getAverageRatingAttribute()
    {
        $userRating = $this->ratings()->avg('rating');
        return $userRating ?? $this->rating ?? 0;
    }

    /**
     * Get the category this movie belongs to.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the streaming URL based on the given plan resolution.
     *
     * @param string|null $planResolution The resolution of the streaming plan (e.g., '720p', '1080p', '4k').
     * @return string The URL for streaming the movie at the given resolution, or empty string if unavailable.
     */
    public function getStreamingUrl(?string $planResolution): string
    {
        // If no resolution specified, default to lowest available
        if ($planResolution === null) {
            $planResolution = '720p';
        }

        // Get the URL based on resolution with fallback chain
        $url = match ($planResolution) {
            '4k' => $this->url_4k ?? $this->url_1080 ?? $this->url_720,
            '1080p' => $this->url_1080 ?? $this->url_720,
            '720p' => $this->url_720,
            default => $this->url_720,
        };

        return $url ?? '';
    }

    /**
     * Accessor untuk atribut 'formatted_duration'.
     * Mengembalikan durasi film dalam format yang mudah dibaca manusia.
     * Contoh: 2h 15m, 
     *         45m, 
     *         1h 2m
     *
     * @return string
     */
    public function getFormattedDurationAttribute()
    {
        $hours = floor($this->duration / 60);
        $minutes = $this->duration % 60;
        $formatted = '';
        if ($hours > 0) {
            $formatted .= "{$hours}h ";
        }
        if ($minutes > 0 || $hours == 0) {
            $formatted .= "{$minutes}m";
        }
        return trim($formatted);
    }

    /**
     * Scope a query to only include movies allowed for a specific user.
     */
    public function scopeForUser($query, $user)
    {
        if (!$user) return $query;

        $category = $user->age_category ?? 'anak';
        
        $allowedRatings = match ($category) {
            'anak' => ['G', 'PG', 'SU', 'Anak'],
            'umum' => ['G', 'PG', 'PG-13', 'SU', '13+'],
            'dewasa' => ['G', 'PG', 'PG-13', 'R', 'NC-17', 'SU', '13+', '17+', '21+'],
            default => ['G', 'PG', 'SU'],
        };

        return $query->whereIn('age_rating', $allowedRatings);
    }
}
