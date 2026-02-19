<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    $name = $request->query('name', 'World');

    return view('welcome', ['greeting' => "Hello, {$name}"]);
})->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::get('/tasks', function () {
    $tasks = [
        'Buy groceries',
        'Walk the dog',
        'Finish Laravel project',
        'Read a book',
        'Go to the gym',
    ];

    return view('tasks', ['tasks' => $tasks]);
})->name('tasks');
