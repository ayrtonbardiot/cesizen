<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class StaticPagesSeeder extends Seeder
{
    public function run(): void
    {
        Page::upsert([
            [
                'slug' => 'a-propos',
                'title' => 'À propos',
                'content' => '<p>Bienvenue sur notre site. Cette page vous en dit plus sur notre mission.</p>',
            ],
            [
                'slug' => 'contact',
                'title' => 'Contact',
                'content' => '<p>Vous pouvez nous contacter par e-mail à contact@example.com ou via notre formulaire.</p>',
            ],
            [
                'slug' => 'conditions-utilisation',
                'title' => 'Conditions d’utilisation',
                'content' => '<p>En utilisant ce site, vous acceptez nos conditions générales.</p>',
            ],
            [
                'slug' => 'politique-confidentialite',
                'title' => 'Politique de confidentialité',
                'content' => '<p>Nous respectons votre vie privée et vos données sont protégées.</p>',
            ],
        ], ['slug'], ['title', 'content']);
    }
}

