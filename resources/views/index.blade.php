<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>{{ config('app.name') }} - Accueil</title>
    @vite('resources/css/app.css')
</head>
<body>
<!--<header>-->
<!--    <nav class="bg-nav">-->
<!--        <img class="h-36" alt="Logo de CESIZen" src="assets/img/CESIZen%20-%20LOGO%20500x500.png">-->
<!--    </nav>-->
<!--</header>-->
<main>
    <!--Section hero-->
    <section class="border-b-2 border-gray-200 bg-nav">
        <div class="p-5 flex flex-col items-center gap-4">
            <img src="assets/img/logo.png" class="">
            <h1 class="text-6xl font-bold text-outline text-nav">PRENEZ SOIN DE VOTRE SANTÉ MENTALE</h1>
            <p class="w-2/6">CESIZen est une application destinée à la gestion du stress et la promotion du bien-être.
                Explorez nos outils pour évaluer et améliorer votre santé mentale.</p>
            <div class="flex flex-row gap-4">
                <a href="{{ route('breathing') }}" class="bg-nav p-4 rounded-xl drop-shadow-sm font-bold">Commencer l'exercice de respiration</a>
                <a href="{{ route('register') }}" class="bg-nav p-4 rounded-xl drop-shadow-sm font-bold">Créer un compte</a>
            </div>
        </div>
    </section>

    <!-- Section témoignages -->
    <section class="border-b-2 border-gray-200">
        <div class="p-5">
            <div class="flex flex-col justify-center">
                <h2 class="text-4xl font-bold text-center">Témoignages</h2>
                <div class="flex flex-row gap-4">
                    <div class="flex bg-gray-100 flex-col items-center w-1/4 p-4 mt-4 rounded-xl">
                        <img class="h-28 rounded-full overflow-hidden" src="assets/img/logo_alt.png">
                        <h2 class="font-bold">John Doe</h2>
                        <p class="text-center">Lorem ipsum mes couilles en ski sur le TMax de Jul sur la canebière merde à la fin ça me
                            casse les couilles d'écrire des textes de fils de pute pour une page de présentation à la
                            con qui va tellement jamais servir.</p>
                    </div>
                    <div class="flex bg-gray-100 flex-col items-center w-1/4 p-4 mt-4 rounded-xl">
                        <img class="h-28 rounded-full overflow-hidden" src="assets/img/logo_alt.png">
                        <h2 class="font-bold">John Doe</h2>
                        <p class="text-center">Lorem ipsum mes couilles en ski sur le TMax de Jul sur la canebière merde à la fin ça me
                            casse les couilles d'écrire des textes de fils de pute pour une page de présentation à la
                            con qui va tellement jamais servir.</p>
                    </div>
                    <div class="flex bg-gray-100 flex-col items-center w-1/4 p-4 mt-4 rounded-xl">
                        <img class="h-28 rounded-full overflow-hidden" src="assets/img/logo_alt.png">
                        <h2 class="font-bold">John Doe</h2>
                        <p class="text-center">Lorem ipsum mes couilles en ski sur le TMax de Jul sur la canebière merde à la fin ça me
                            casse les couilles d'écrire des textes de fils de pute pour une page de présentation à la
                            con qui va tellement jamais servir.</p>
                    </div>
                    <div class="flex bg-gray-100 flex-col items-center w-1/4 p-4 mt-4 rounded-xl">
                        <img class="h-28 rounded-full overflow-hidden" src="assets/img/logo_alt.png">
                        <h2 class="font-bold">John Doe</h2>
                        <p class="text-center">Lorem ipsum mes couilles en ski sur le TMax de Jul sur la canebière merde à la fin ça me
                            casse les couilles d'écrire des textes de fils de pute pour une page de présentation à la
                            con qui va tellement jamais servir.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section je sais pas encore -->
    <section class="border-b-2 border-gray-200">
        <div class="p-5 flex flex-col items-center gap-2">
            <h1 class="text-4xl font-bold">Alors, convaincu ?</h1>
            <p class="text-xl">Essayez nos outils gratuitement, dès maintenant !</p>
        </div>
    </section>
</main>
<footer class="bg-sky-900">
    <div class="flex flex-row items-center justify-between text-white text-yellow-500 h-24 mx-5">
        <div>
            <p>© 2025 CESIZen</p>
        </div>
        <div>
            <a href="#">Mentions légales</a>
            <a href="#">Politique de confidentialité</a>
        </div>
    </div>
</footer>
</body>
</html>
