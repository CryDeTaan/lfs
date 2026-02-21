<?php

use App\Http\Controllers\IdeaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IdeaController::class, 'index'])->name('ideas.index');

Route::resource('ideas', IdeaController::class)->except(['index', 'create']);

Route::patch('/ideas/{idea}/state', [IdeaController::class, 'state'])->name('ideas.state');

require __DIR__.'/old.php';
