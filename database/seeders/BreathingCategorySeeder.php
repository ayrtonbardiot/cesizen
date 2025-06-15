<?php

namespace Database\Seeders;

use App\Models\BreathingCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class BreathingCategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('breathing_categories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

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

        foreach ($categories as $category) {
            BreathingCategory::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'is_active' => true,
            ]);
        }
    }
} 