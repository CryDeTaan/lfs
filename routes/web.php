<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    $ideas = $request->session()->get('ideas', []);

    return view('ideas.index', ['ideas' => $ideas]);
})->name('ideas.index');

Route::post('/ideas', function (Request $request) {
    $validated = $request->validate([
        'idea' => ['required', 'string', 'max:255'],
    ]);

    $ideas = $request->session()->get('ideas', []);
    $ideas[] = $validated['idea'];
    $request->session()->put('ideas', $ideas);

    return redirect()->back();
})->name('ideas.store');

Route::delete('/ideas', function (Request $request) {
    $request->session()->forget('ideas');

    return redirect()->back();
})->name('ideas.clear');

require __DIR__.'/old.php';
