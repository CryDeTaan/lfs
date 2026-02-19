<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    $name = $request->query('name', 'World');

    return view('welcome', ['greeting' => "Hello, {$name}"]);
})->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
