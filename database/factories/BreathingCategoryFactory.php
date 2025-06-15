<?php

namespace Database\Factories;

use App\Models\BreathingCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BreathingCategory>
 */
class BreathingCategoryFactory extends Factory
{
    protected $model = BreathingCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            [
                'name' => 'Stress',
                'description' => 'Exercices pour réduire le stress et l\'anxiété',
            ],
            [
                'name' => 'Concentration',
                'description' => 'Exercices pour améliorer la concentration et la clarté mentale',
            ],
            [
                'name' => 'Sommeil',
                'description' => 'Exercices pour favoriser un sommeil réparateur',
            ],
            [
                'name' => 'Énergie',
                'description' => 'Exercices pour augmenter l\'énergie et la vitalité',
            ],
            [
                'name' => 'Méditation',
                'description' => 'Exercices de respiration pour la méditation',
            ],
            [
                'name' => 'Relaxation',
                'description' => 'Exercices pour se détendre et se relaxer',
            ],
        ];

        $category = $this->faker->unique()->randomElement($categories);
        return [
            'name' => $category['name'],
            'description' => $category['description'],
            'slug' => Str::slug($category['name']),
            'is_active' => true,
        ];
    }
}
