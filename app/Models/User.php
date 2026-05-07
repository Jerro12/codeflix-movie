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
        'nik',
        'birth_date',
        'age_category',
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
            'birth_date' => 'date',
        ];
    }
    
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($user) {
            if ($user->isDirty('birth_date') && $user->birth_date) {
                $age = $user->birth_date->age;
                
                if ($age < 13) {
                    $user->age_category = 'anak';
                } elseif ($age >= 13 && $age < 18) {
                    $user->age_category = 'umum';
                } else {
                    $user->age_category = 'dewasa';
                }
            }
        });
    }

    /**
     * Get the user's age.
     */
    public function getAgeAttribute()
    {
        return $this->birth_date ? $this->birth_date->age : null;
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
        return true; // Everyone has access now
    }

    public function getCurrentPlan()
    {
        // Return a dummy plan object with high resolution
        return (object) [
            'name' => 'Premium',
            'resolution' => '4K',
            'devices_limit' => 4,
        ];
    }
}
