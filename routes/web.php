<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    LoginController,
    IndexController,
    RegisterController,
    DashboardController,
    ProfileController,
    BreathingExerciseController,
};
use App\Http\Controllers\Admin\{
    BreathingExerciseController as AdminBreathingExerciseController,
    DashboardController as AdminDashboardController,
    UserController as AdminUserController,
    SettingsController as AdminSettingsController
};
use App\Http\Controllers\Api\{
    BreathingSessionController as ApiBreathingSessionController
};
use Nette\NotImplementedException;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// Accueil
Route::get('/', [IndexController::class, 'view'])->name('index');

// Auth
Route::prefix('auth')->group(function () {
    Route::get('/login', [LoginController::class, 'view'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Inscription
Route::get('/register', [RegisterController::class, 'view'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

// Exercices de respiration (accessibles à tous)
Route::get('/breathing', [BreathingExerciseController::class, 'index'])->name('breathing.index');
Route::get('/breathing/{exercise}', [BreathingExerciseController::class, 'show'])->name('breathing.show');

// Utilisateur connecté
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'view'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'view'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::get('/profile/download-data', [ProfileController::class, 'downloadPersonalData'])->name('profile.download-data');
    Route::delete('/profile/delete', [ProfileController::class, 'deleteAccount'])->name('profile.delete');
});

// Admin uniquement
Route::middleware(['auth', 'admin', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', AdminUserController::class)->names('users');
    Route::resource('breathing', AdminBreathingExerciseController::class)->names('breathing');
    Route::get('/settings', [AdminSettingsController::class, 'edit'])->name('settings');
    Route::put('/settings', [AdminSettingsController::class, 'update'])->name('settings.update');
});



// Routes pour la vérif email
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard'); // Redirige après vérification
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Le lien de vérification a été renvoyé.');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

//TODO: bouger dans le fichier api.php
// Routes pour l'API authentifiée
Route::middleware(['auth:sanctum'])->group(function () {
})->prefix('api');

// Routes API non authentifiée
Route::prefix('api')->group(function () {
    Route::post('/breathing/session', [ApiBreathingSessionController::class, 'store'])->name('breathing.session');
});
