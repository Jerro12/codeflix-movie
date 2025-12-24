<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    /**
     * Get all of the user's memberships.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Membership>
     */
    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }

    public function devices()
    {
        return $this->hasMany(UserDevice::class);
    }

    /**
     * Get user's watchlist entries.
     */
    public function watchlist()
    {
        return $this->hasMany(Watchlist::class);
    }

    /**
     * Get user's watch history.
     */
    public function watchHistory()
    {
        return $this->hasMany(WatchHistory::class);
    }

    /**
     * Get user's profiles (multiple profiles feature).
     */
    public function profiles()
    {
        return $this->hasMany(Profile::class);
    }

    /**
     * Get user's reviews.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin(): bool
    {
        return $this->is_admin ?? false;
    }

    /**
     * Check if a movie is in user's watchlist.
     */
    public function hasInWatchlist(int $movieId): bool
    {
        return $this->watchlist()->where('movie_id', $movieId)->exists();
    }

    /**
     * Check if the user has an active membership plan.
     *
     * @return bool True if the user has an active membership plan, false otherwise.
     */
    public function hasMembershipPlan()
    {
        return $this->memberships()
            ->where('active', '=', true)
            ->where('end_date', '>', now())
            ->exists();
    }

    public function getCurrentPlan()
    {
        $activeMembership = $this->memberships()
            ->where('active', '=', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->latest()
            ->first();

        if (!$activeMembership) {
            return null;
        }

        return Plan::find($activeMembership->plan_id);
    }
}
