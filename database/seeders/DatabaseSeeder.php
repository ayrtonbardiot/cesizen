<?php

namespace Database\Seeders;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // on seed les exo et les categories
        $this->call([
            BreathingCategorySeeder::class,
            BreathingExerciseSeeder::class,
        ]);
    }
}
