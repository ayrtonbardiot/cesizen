<?php

namespace Database\Seeders;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // on seed auto un compte admin
        User::create([
            'email' => 'admin@cesizen.ayrtonbardiot.fr',
            'password' => 'Adm!nFr0mC3s!z3N!$36000',
            'name' => 'Administrateur',
            'email_verified_at' => now(),
            'role' => 'admin'
        ]);
        // on seed articles, exercices & categories
        $this->call([
            BreathingCategorySeeder::class,
            BreathingExerciseSeeder::class,
            ArticleSeeder::class,
        ]);
    }
}
