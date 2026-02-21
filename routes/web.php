<?php

use App\Http\Controllers\IdeaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IdeaController::class, 'index'])->name('ideas.index');

Route::resource('ideas', IdeaController::class)->except(['index', 'create']);

require __DIR__.'/old.php';
