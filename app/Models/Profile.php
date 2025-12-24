<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'avatar',
        'is_kids',
        'pin',
        'preferences',
    ];

    protected $casts = [
        'is_kids' => 'boolean',
        'preferences' => 'array',
    ];

    /**
     * Get the user that owns this profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the watch history for this profile.
     */
    public function watchHistory(): HasMany
    {
        return $this->hasMany(WatchHistory::class, 'user_id', 'user_id');
    }

    /**
     * Check if PIN is required and matches.
     */
    public function validatePin(?string $pin): bool
    {
        if (!$this->pin) {
            return true;
        }
        return $this->pin === $pin;
    }

    /**
     * Get avatar URL or default.
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return $this->avatar;
        }
        
        // Generate color-based avatar
        $colors = ['#E50914', '#1ABC9C', '#3498DB', '#9B59B6', '#F39C12'];
        $color = $colors[$this->id % count($colors)];
        $initial = strtoupper(substr($this->name, 0, 1));
        
        return "data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='100' height='100'><rect fill='{$color}' width='100' height='100'/><text x='50%' y='50%' dy='.1em' fill='white' font-family='Inter,sans-serif' font-size='48' font-weight='600' text-anchor='middle' dominant-baseline='middle'>{$initial}</text></svg>";
    }
}
