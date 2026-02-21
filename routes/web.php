<?php

use App\Http\Controllers\IdeaController;
use App\Http\Controllers\ToggleIdeaStateController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IdeaController::class, 'index'])->name('ideas.index');

Route::resource('ideas', IdeaController::class)->except(['index', 'create']);

Route::patch('ideas/{idea}/toggle-state', ToggleIdeaStateController::class)->name('ideas.toggle-state');

require __DIR__.'/old.php';
