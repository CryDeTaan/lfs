<?php

use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $ideas = Idea::query()->latest()->get();

    return view('ideas.index', ['ideas' => $ideas]);
})->name('ideas.index');

Route::post('/ideas', function (Request $request) {
    $validated = $request->validate([
        'idea' => ['required', 'string', 'max:255'],
    ]);

    Idea::query()->create(['description' => $validated['idea']]);

    return redirect()->back();
})->name('ideas.store');

Route::delete('/ideas', function () {
    Idea::query()->truncate();

    return redirect()->back();
})->name('ideas.clear');

require __DIR__.'/old.php';
