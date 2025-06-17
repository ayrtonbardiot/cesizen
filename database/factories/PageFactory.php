<?php

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PageFactory extends Factory
{
    protected $model = Page::class;

    public function definition(): array
    {
        $title = $this->faker->unique()->words(2, true); // ex: "Politique confidentialité"
        return [
            'title' => ucfirst($title),
            'slug' => Str::slug($title),
            'content' => $this->faker->paragraphs(3, true),
            'is_visible' => $this->faker->boolean(70),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Indiquer que la page est visible publiquement.
     */
    public function visible(): static
    {
        return $this->state(fn () => ['is_visible' => true]);
    }

    /**
     * Indiquer que la page est cachée.
     */
    public function hidden(): static
    {
        return $this->state(fn () => ['is_visible' => false]);
    }
}