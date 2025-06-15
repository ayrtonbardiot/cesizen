<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BreathingExercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category_id',
        'steps',
        'image_path',
        'is_active'
    ];

    protected $casts = [
        'steps' => 'array',
        'is_active' => 'boolean'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(BreathingCategory::class, 'category_id');
    }

    public function getFormattedDurationAttribute()
    {
        $minutes = floor($this->duration / 60);
        $seconds = $this->duration % 60;
        
        if ($minutes > 0) {
            return sprintf('%d min %d sec', $minutes, $seconds);
        }
        
        return sprintf('%d sec', $seconds);
    }

    public function getDifficultyLabelAttribute()
    {
        return match($this->difficulty) {
            'easy' => 'Facile',
            'medium' => 'Moyen',
            'hard' => 'Difficile',
            default => $this->difficulty,
        };
    }

    public function getCategoryLabelAttribute()
    {
        return match($this->category) {
            'stress' => 'Stress',
            'anxiety' => 'Anxiété',
            'focus' => 'Concentration',
            'sleep' => 'Sommeil',
            'energy' => 'Énergie',
            default => $this->category,
        };
    }

    /*
     * Get all breathing sessions launched from this exercise
     * 
     * @return BreathingSession[]
     */
    public function sessions()
    {
        return $this->hasMany(BreathingSession::class);
    }
}
