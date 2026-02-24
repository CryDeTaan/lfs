<?php

use App\Models\User;

test('the registration page is accessible', function () {
    $this->get('/register')
        ->assertSuccessful()
        ->assertSeeText('Create an account');
});

test('a user can register with valid data', function () {
    $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertRedirect(route('ideas.index'));

    $this->assertAuthenticated();
    $this->assertDatabaseHas('users', [
        'name' => 'Test User',
        'email' => 'test@example.com',
    ]);
});

test('registration requires a name', function () {
    $this->post('/register', [
        'name' => '',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertSessionHasErrors('name');
});

test('registration requires a valid email', function () {
    $this->post('/register', [
        'name' => 'Test User',
        'email' => 'not-an-email',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertSessionHasErrors('email');
});

test('registration requires a unique email', function () {
    User::factory()->create(['email' => 'taken@example.com']);

    $this->post('/register', [
        'name' => 'Test User',
        'email' => 'taken@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertSessionHasErrors('email');
});

test('registration requires a password with at least 8 characters', function () {
    $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'short',
        'password_confirmation' => 'short',
    ])->assertSessionHasErrors('password');
});

test('registration requires password confirmation', function () {
    $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'different',
    ])->assertSessionHasErrors('password');
});

test('the login page is accessible', function () {
    $this->get('/login')
        ->assertSuccessful()
        ->assertSeeText('Welcome back');
});

test('a user can login with valid credentials', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    $this->post('/login', [
        'email' => 'test@example.com',
        'password' => 'password',
    ])->assertRedirect(route('ideas.index'));

    $this->assertAuthenticatedAs($user);
});

test('login fails with incorrect credentials', function () {
    User::factory()->create([
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    $this->post('/login', [
        'email' => 'test@example.com',
        'password' => 'wrong-password',
    ])->assertSessionHasErrors('email');

    $this->assertGuest();
});

test('login requires an email', function () {
    $this->post('/login', [
        'email' => '',
        'password' => 'password',
    ])->assertSessionHasErrors('email');
});

test('login requires a password', function () {
    $this->post('/login', [
        'email' => 'test@example.com',
        'password' => '',
    ])->assertSessionHasErrors('password');
});

test('a user can logout', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post('/logout')
        ->assertRedirect(route('login'));

    $this->assertGuest();
});

test('guests are redirected to login when accessing ideas', function () {
    $this->get('/')
        ->assertRedirect(route('login'));
});

test('authenticated users are redirected from login page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/login')
        ->assertRedirect('/');
});

test('authenticated users are redirected from register page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/register')
        ->assertRedirect('/');
});
