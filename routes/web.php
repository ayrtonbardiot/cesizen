<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\{
    IndexController,
    LoginController,
    RegisterController,
    DashboardController,
    ProfileController,
    BreathingExerciseController,
    ForgotPasswordController,
    ResetPasswordController
};
use App\Http\Controllers\Admin\{
    DashboardController as AdminDashboardController,
    BreathingExerciseController as AdminBreathingExerciseController,
    UserController as AdminUserController
};
use App\Http\Controllers\Api\{
    BreathingSessionController as ApiBreathingSessionController
};

/*
|--------------------------------------------------------------------------
| Routes Web
|--------------------------------------------------------------------------
*/

// Accueil
Route::get('/', [IndexController::class, 'view'])->name('index');

// Authentification
Route::prefix('auth')->group(function () {
    // Connexion
    Route::get('/login', [LoginController::class, 'view'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    // Inscription
    Route::get('/register', [RegisterController::class, 'view'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

    // Mot de passe oublié
    Route::get('/forgot-password', [ForgotPasswordController::class, 'view'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    // Réinitialisation du mot de passe
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'view'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])->name('password.update');
});

// Exercices de respiration (public)
Route::get('/breathing', [BreathingExerciseController::class, 'index'])->name('breathing.index');
Route::get('/breathing/{exercise}', [BreathingExerciseController::class, 'show'])->name('breathing.show');

// Espace utilisateur (auth + email vérifié)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'view'])->name('dashboard');

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'view'])->name('index');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password');
        Route::get('/download-data', [ProfileController::class, 'downloadPersonalData'])->name('download-data');
        Route::delete('/delete', [ProfileController::class, 'deleteAccount'])->name('delete');
    });
});

// Administration (auth + admin + email vérifié)
Route::middleware(['auth', 'admin', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', AdminUserController::class)->names('users');
    Route::resource('breathing', AdminBreathingExerciseController::class)->names('breathing');
});

// Vérification de l'email
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', fn() => view('auth.verify-email'))->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/dashboard');
    })->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Le lien de vérification a été renvoyé.');
    })->middleware('throttle:6,1')->name('verification.send');
});

// API publique
Route::prefix('api')->group(function () {
    Route::post('/breathing/session', [ApiBreathingSessionController::class, 'store'])->name('breathing.session');
});

// TODO: déplacer dans routes/api.php si besoin
Route::prefix('api')->middleware(['auth:sanctum'])->group(function () {
    // Routes API protégées (à définir)
});
