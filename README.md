# 🌿 Cesizen

Cesizen est une plateforme web de soutien à la santé mentale développée avec **Laravel**, **TailwindCSS** et **Vite**.  
Elle propose des outils interactifs tels que des exercices de respiration, des modules de diagnostic, un suivi émotionnel et bien plus.

---

## 🚀 Fonctionnalités principales

- ~~🔍 Diagnostic de santé mentale interactif~~ (Indisponible)
- 🌬️ Exercices de respiration
- ~~📈 Suivi émotionnel au quotidien~~ (Indisponible)
- 👤 Espace personnel sécurisé avec export des données
- 🎨 UI responsive et accessible avec TailwindCSS
- ✅ Batterie de tests automatisés

---

## 🛠️ Stack technique

| Outil | Description |
|------|-------------|
| [Laravel](https://laravel.com/) | Framework back-end PHP |
| [TailwindCSS](https://tailwindcss.com/) | Framework CSS utilitaire |
| [Vite](https://vitejs.dev/) | Bundler ultra-rapide pour assets (JS/CSS) |
| [Blade](https://laravel.com/docs/blade) | Moteur de template Laravel |
| [PHPUnit](https://phpunit.de) (intégré à Laravel) | Framework de tests automatisés |
| MySQL | Base de données |

---

## ✅ Résultats des derniers tests

[Voir le PDF](./FICHES-TESTS_LAST.pdf)

---

## 📦 Installation locale

```bash
git clone https://github.com/ayrtonbardiot/cesizen.git
cd cesizen

# Installer les dépendances PHP
composer install

# Installer les dépendances JS
npm install

# Copier et configurer l'environnement
cp .env.example .env
php artisan key:generate

# Configurer ta base de données dans .env
# DB_DATABASE=cesizen
# DB_USERNAME=...
# DB_PASSWORD=...

# Lancer les migrations et seeders
php artisan migrate --seed

# Lancer le serveur de développement Vite pour la compilation des assets
npm run dev
