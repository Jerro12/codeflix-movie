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
        'poster',
        'trailer_url',
        'banner',
        'release_date',
        'duration',
        'age_rating',
        'url_720',
        'url_1080',
        'url_4k',
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
     * Menghitung rata-rata rating dari semua rating yang terkait dengan movie ini.
     *
     * @return float
     */
    public function getAverageRatingAttribute()
    {
        return $this->ratings()->avg('rating');
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
        // Hitung berapa jam yang diperlukan untuk menonton film
        $hours = floor($this->duration / 60);

        // Hitung berapa menit yang diperlukan untuk menonton film
        $minutes = $this->duration % 60;

        // Inisialisasi string yang akan diisi dengan durasi yang diformat
        $formatted = '';

        // Jika durasi lebih dari 0 jam, maka tambahkan informasinya ke string
        if ($hours > 0) {
            $formatted .= "{$hours}h ";
        }

        // Jika durasi lebih dari 0 menit atau durasi sama dengan 0 jam, maka
        // tambahkan informasinya ke string
        if ($minutes > 0 || $hours == 0) {
            $formatted .= "{$minutes}m";
        }

        // Kembalikan string (tanpa awal&akhir spasi kosong) yang telah diisi dengan durasi yang diformat
        return trim($formatted);
    }
}
