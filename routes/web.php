<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome', ['greeting' => 'hello world'])->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
