<?php

use App\Models\User;

test('a user can register through the browser', function () {
    $page = visit('/register');

    $page->assertSee('Create an account')
        ->fill('#name', 'Test User')
        ->fill('#email', 'browser@example.com')
        ->fill('#password', 'password')
        ->fill('#password_confirmation', 'password')
        ->submit('form')
        ->assertPathIs('/');

    $this->assertAuthenticated();
    $this->assertDatabaseHas('users', ['email' => 'browser@example.com']);
});

test('a user can log in through the browser', function () {
    User::factory()->create([
        'email' => 'login@example.com',
        'password' => 'password',
    ]);

    $page = visit('/login');

    $page->assertSee('Welcome back')
        ->fill('#email', 'login@example.com')
        ->fill('#password', 'password')
        ->submit('form')
        ->assertPathIs('/');

    $this->assertAuthenticated();
});

test('login shows error with invalid credentials', function () {
    User::factory()->create([
        'email' => 'user@example.com',
        'password' => 'password',
    ]);

    $page = visit('/login');

    $page->fill('#email', 'user@example.com')
        ->fill('#password', 'wrong-password')
        ->submit('form')
        ->assertPathIs('/login')
        ->assertSee('These credentials do not match our records');
});

test('a user can log out through the browser', function () {
    User::factory()->create([
        'email' => 'logout@example.com',
        'password' => 'password',
    ]);

    $page = visit('/login');

    $page->fill('#email', 'logout@example.com')
        ->fill('#password', 'password')
        ->submit('form')
        ->assertPathIs('/')
        ->press('Logout')
        ->assertPathIs('/login');

    $this->assertGuest();
});

test('guests are redirected to login page', function () {
    $page = visit('/');

    $page->assertPathIs('/login');
});

test('register page links to login', function () {
    $page = visit('/register');

    $page->click('Log in')
        ->assertPathIs('/login');
});

test('login page links to register', function () {
    $page = visit('/login');

    $page->click('Register')
        ->assertPathIs('/register');
});
