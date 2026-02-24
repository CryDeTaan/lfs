<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\ToggleIdeaStateController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
    Route::get('/login', [SessionController::class, 'create'])->name('login');
    Route::post('/login', [SessionController::class, 'store'])->middleware('throttle:5,1');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [SessionController::class, 'destroy'])->name('logout');

    Route::get('/', [IdeaController::class, 'index'])->name('ideas.index');
    Route::resource('ideas', IdeaController::class)->except(['index', 'create']);
    Route::patch('ideas/{idea}/toggle-state', ToggleIdeaStateController::class)->name('ideas.toggle-state');
});

require __DIR__.'/old.php';
