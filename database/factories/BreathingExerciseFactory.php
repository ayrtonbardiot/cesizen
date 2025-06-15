<?php

namespace Database\Factories;

use App\Models\BreathingExercise;
use App\Models\BreathingCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BreathingExercise>
 */
class BreathingExerciseFactory extends Factory
{
    protected $model = BreathingExercise::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $exercises = [
            [
                'title' => 'Cohérence cardiaque',
                'description' => 'Exercice pour réduire le stress et améliorer la concentration.',
                'steps' => [
                    ['text' => 'Inspirez profondément pendant 5 secondes.', 'duration' => 5, 'type' => 'inspire'],
                    ['text' => 'Expirez lentement pendant 5 secondes.', 'duration' => 5, 'type' => 'expire'],
                    ['text' => 'Répétez ce cycle pendant 5 minutes.', 'duration' => 300, 'type' => 'repeat'],
                ],
            ],
            [
                'title' => 'Respiration abdominale',
                'description' => 'Favorise la relaxation et la détente.',
                'steps' => [
                    ['text' => 'Placez une main sur votre ventre.', 'duration' => 10, 'type' => 'instruction'],
                    ['text' => 'Inspirez lentement par le nez en gonflant le ventre.', 'duration' => 5, 'type' => 'inspire'],
                    ['text' => 'Expirez doucement par la bouche.', 'duration' => 5, 'type' => 'expire'],
                    ['text' => 'Répétez pendant 3 à 5 minutes.', 'duration' => 180, 'type' => 'repeat'],
                ],
            ],
            [
                'title' => '4-7-8',
                'description' => "Technique pour favoriser l'endormissement.",
                'steps' => [
                    ['text' => 'Inspirez par le nez pendant 4 secondes.', 'duration' => 4, 'type' => 'inspire'],
                    ['text' => 'Retenez votre souffle pendant 7 secondes.', 'duration' => 7, 'type' => 'hold'],
                    ['text' => 'Expirez lentement par la bouche pendant 8 secondes.', 'duration' => 8, 'type' => 'expire'],
                    ['text' => 'Répétez 4 fois.', 'duration' => 120, 'type' => 'repeat'],
                ],
            ],
            [
                'title' => 'Respiration carrée',
                'description' => 'Exercice pour améliorer la concentration et la clarté mentale.',
                'steps' => [
                    ['text' => 'Inspirez pendant 4 secondes.', 'duration' => 4, 'type' => 'inspire'],
                    ['text' => 'Retenez pendant 4 secondes.', 'duration' => 4, 'type' => 'hold'],
                    ['text' => 'Expirez pendant 4 secondes.', 'duration' => 4, 'type' => 'expire'],
                    ['text' => 'Pause pendant 4 secondes.', 'duration' => 4, 'type' => 'hold'],
                    ['text' => 'Répétez 5 fois.', 'duration' => 100, 'type' => 'repeat'],
                ],
            ],
        ];

        $exercise = $this->faker->randomElement($exercises);
        $category = BreathingCategory::factory()->create();
        return [
            'title' => $exercise['title'],
            'description' => $exercise['description'],
            'category_id' => $category->id,
            'steps' => $exercise['steps'],
            'image_path' => null,
            'is_active' => true,
        ];
    }
}
