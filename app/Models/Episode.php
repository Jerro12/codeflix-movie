<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Episode extends Model
{
    protected $fillable = [
        'season_id',
        'number',
        'title',
        'description',
        'duration',
        'thumbnail',
        'url_720',
        'url_1080',
        'url_4k',
    ];

    protected $casts = [
        'duration' => 'integer',
    ];

    /**
     * Get the season this episode belongs to.
     */
    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    /**
     * Get the series this episode belongs to (through season).
     */
    public function series()
    {
        return $this->season->series;
    }

    /**
     * Get formatted duration.
     */
    public function getFormattedDurationAttribute(): string
    {
        $hours = floor($this->duration / 60);
        $minutes = $this->duration % 60;
        
        if ($hours > 0) {
            return "{$hours}h {$minutes}m";
        }
        return "{$minutes}m";
    }

    /**
     * Get streaming URL based on resolution.
     */
    public function getStreamingUrl(?string $resolution = '1080'): string
    {
        return match($resolution) {
            '4k', '2160' => $this->url_4k ?? $this->url_1080 ?? $this->url_720 ?? '',
            '1080' => $this->url_1080 ?? $this->url_720 ?? '',
            '720' => $this->url_720 ?? '',
            default => $this->url_1080 ?? $this->url_720 ?? '',
        };
    }

    /**
     * Get episode identifier (e.g., S01E05).
     */
    public function getEpisodeCodeAttribute(): string
    {
        $season = str_pad($this->season->number, 2, '0', STR_PAD_LEFT);
        $episode = str_pad($this->number, 2, '0', STR_PAD_LEFT);
        return "S{$season}E{$episode}";
    }
}
