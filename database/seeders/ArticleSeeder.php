<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Les bienfaits de la respiration consciente',
                'content' => '<p>La respiration consciente est une pratique millénaire qui trouve ses racines dans diverses traditions orientales. Cette technique simple mais puissante peut transformer votre vie quotidienne en vous aidant à gérer le stress, améliorer votre concentration et renforcer votre bien-être général.</p>

<p>Voici les principaux avantages de la respiration consciente :</p>
<ul>
    <li>Réduction du stress et de l\'anxiété</li>
    <li>Amélioration de la concentration</li>
    <li>Meilleure gestion des émotions</li>
    <li>Renforcement du système immunitaire</li>
    <li>Amélioration de la qualité du sommeil</li>
</ul>

<p>Pour commencer, prenez simplement quelques minutes chaque jour pour vous concentrer sur votre respiration. Inspirez profondément par le nez, sentez votre ventre se gonfler, puis expirez lentement par la bouche. Répétez ce cycle pendant 5 à 10 minutes.</p>',
                'author' => 'Dr. Sophie Martin',
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Techniques de respiration pour les débutants',
                'content' => '<p>Découvrez les techniques de respiration fondamentales pour débuter votre pratique. Ces exercices simples peuvent être pratiqués n\'importe où et ne nécessitent aucun équipement spécial.</p>

<h3>1. La respiration carrée</h3>
<p>Cette technique consiste à respirer en suivant un rythme égal pour l\'inspiration, la rétention, l\'expiration et la pause.</p>

<h3>2. La respiration abdominale</h3>
<p>Concentrez-vous sur le mouvement de votre ventre pendant la respiration, en le laissant se gonfler à l\'inspiration et se dégonfler à l\'expiration.</p>

<h3>3. La respiration alternée</h3>
<p>Alterner la respiration entre les narines droite et gauche pour équilibrer l\'énergie et calmer l\'esprit.</p>',
                'author' => 'Marc Dubois',
                'is_published' => true,
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'La respiration et le sport : un duo gagnant',
                'content' => '<p>La respiration joue un rôle crucial dans la performance sportive. Une bonne technique respiratoire peut améliorer significativement vos résultats et votre récupération.</p>

<h3>Avantages de la respiration contrôlée pendant l\'exercice :</h3>
<ul>
    <li>Meilleure oxygénation des muscles</li>
    <li>Réduction de la fatigue</li>
    <li>Amélioration de l\'endurance</li>
    <li>Récupération plus rapide</li>
</ul>

<p>Pratiquez la respiration rythmée pendant vos entraînements pour maximiser vos performances et votre bien-être.</p>',
                'author' => 'Coach Thomas',
                'is_published' => true,
                'published_at' => now()->subDays(4),
            ],
            [
                'title' => 'Méditation et respiration : le guide complet',
                'content' => '<p>La méditation et la respiration sont intimement liées. Découvrez comment ces deux pratiques se complètent pour créer une expérience de bien-être profonde.</p>

<h3>Les bases de la méditation respiratoire :</h3>
<ol>
    <li>Trouvez un endroit calme et confortable</li>
    <li>Asseyez-vous dans une position stable</li>
    <li>Concentrez-vous sur votre respiration</li>
    <li>Observez les pensées sans les juger</li>
    <li>Revenez doucement à votre respiration</li>
</ol>

<p>Pratiquez régulièrement pour développer votre concentration et votre sérénité.</p>',
                'author' => 'Emma Laurent',
                'is_published' => true,
                'published_at' => now()->subDays(6),
            ],
            [
                'title' => 'La respiration pour un meilleur sommeil',
                'content' => '<p>Les troubles du sommeil affectent de nombreuses personnes. Découvrez comment la respiration peut vous aider à améliorer la qualité de votre sommeil.</p>

<h3>Techniques de respiration pour le sommeil :</h3>
<ul>
    <li>La respiration 4-7-8</li>
    <li>La respiration progressive</li>
    <li>La respiration abdominale</li>
</ul>

<p>Ces techniques peuvent être pratiquées au coucher pour favoriser l\'endormissement et améliorer la qualité du sommeil.</p>',
                'author' => 'Dr. Julie Moreau',
                'is_published' => true,
                'published_at' => now()->subDays(8),
            ],
        ];

        foreach ($articles as $article) {
            Article::create([
                'title' => $article['title'],
                'slug' => Str::slug($article['title']),
                'content' => $article['content'],
                'author' => $article['author'],
                'is_published' => $article['is_published'],
                'published_at' => $article['published_at'],
            ]);
        }
    }
}
