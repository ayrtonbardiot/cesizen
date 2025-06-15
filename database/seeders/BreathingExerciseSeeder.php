<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BreathingExercise;
use App\Models\BreathingCategory;
use Illuminate\Support\Facades\DB;

class BreathingExerciseSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('breathing_exercises')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $categories = BreathingCategory::all()->keyBy('slug');

        $exercises = [
            [
                'title' => 'Cohérence cardiaque',
                'description' => 'Exercice pour réduire le stress et améliorer la concentration.',
                'steps' => [
                    ['text' => 'Inspirez profondément pendant 5 secondes.', 'duration' => 5, 'type' => 'inspire'],
                    ['text' => 'Expirez lentement pendant 5 secondes.', 'duration' => 5, 'type' => 'expire'],
                    ['text' => 'Répétez ce cycle pendant 5 minutes.', 'duration' => 300, 'type' => 'repeat'],
                ],
                'image_path' => null,
                'category_id' => $categories['stress']->id ?? $categories->first()->id,
                'is_active' => true,
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
                'image_path' => null,
                'category_id' => $categories['relaxation']->id ?? $categories->first()->id,
                'is_active' => true,
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
                'image_path' => null,
                'category_id' => $categories['sommeil']->id ?? $categories->first()->id,
                'is_active' => true,
            ],
        ];

        foreach ($exercises as $exercise) {
            BreathingExercise::create($exercise);
        }
    }
} 