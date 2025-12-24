<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Referral extends Model
{
    protected $fillable = [
        'referrer_id',
        'referred_id',
        'code',
        'bonus_days',
        'status',
        'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    /**
     * Boot method to generate unique code.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($referral) {
            if (!$referral->code) {
                $referral->code = self::generateUniqueCode();
            }
        });
    }

    /**
     * Generate a unique referral code.
     */
    public static function generateUniqueCode(): string
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (self::where('code', $code)->exists());

        return $code;
    }

    /**
     * Get the user who created this referral.
     */
    public function referrer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    /**
     * Get the user who was referred.
     */
    public function referred(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referred_id');
    }

    /**
     * Mark referral as completed.
     */
    public function markAsCompleted(): void
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }

    /**
     * Check if referral is still valid (pending and not expired).
     */
    public function isValid(): bool
    {
        return $this->status === 'pending' && 
               $this->created_at->addDays(30)->isFuture();
    }
}
