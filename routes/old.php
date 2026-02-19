<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('old')->group(function () {
    Route::get('/', function (Request $request) {
        $name = $request->query('name', 'World');

        return view('welcome', ['greeting' => "Hello, {$name}"]);
    })->name('old.home');
    Route::view('/about', 'about')->name('old.about');
    Route::view('/contact', 'contact')->name('old.contact');
    Route::get('/tasks', function () {
        $tasks = [
            'Buy groceries',
            'Walk the dog',
            'Finish Laravel project',
            'Read a book',
            'Go to the gym',
        ];

        return view('tasks', ['tasks' => $tasks]);
    })->name('old.tasks');
});
