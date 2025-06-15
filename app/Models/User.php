<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
            'last_login_at' => 'datetime',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail);
    }

    /**
     * Get if user is admin or not
     * 
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /*
     * Get breathing sessions launched by the user
     * 
     * @return BreathingSession
     */
    public function breathingSessions()
    {
        return $this->hasMany(BreathingSession::class);
    }

    public function currentBreathingStreak(): int
    {
        $dates = $this->breathingSessions() // relation dans le modèle User
            ->whereNotNull('started_at')
            ->orderBy('started_at', 'desc')
            ->get()
            ->pluck('started_at')
            ->map(fn ($date) => $date->startOfDay()->toDateString())
            ->unique()
            ->values();

        $streak = 0;
        $today = now()->startOfDay();

        foreach ($dates as $index => $date) {
            $expected = $today->copy()->subDays($index)->toDateString();
            if ($date === $expected) {
                $streak++;
            } else {
                break;
            }
        }

        return $streak;
    }
}
