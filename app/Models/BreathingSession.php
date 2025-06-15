<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BreathingSession extends Model
{
    protected $fillable = [
        'user_id',
        'breathing_exercise_id',
        'started_at',
        'ended_at',
        'duration_seconds'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function exercise() {
        return $this->belongsTo(BreathingExercise::class, 'breathing_exercise_id');
    }
}
