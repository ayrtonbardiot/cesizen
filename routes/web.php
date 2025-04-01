<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;

Route::get('/', [IndexController::class, 'view'])->name('index');
Route::get('/breathing/', function () {
    throw new \Nette\NotImplementedException('Breathing is not implemented yet.');
})->name('breathing');
Route::get('/register', function () {
    throw new \Nette\NotImplementedException('Registration is not implemented yet.');
})->name('register');
