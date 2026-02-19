<?php

test('the home page returns a successful response', function () {
    $this->get('/')->assertSuccessful();
});

test('the home page displays default greeting', function () {
    $this->get('/')
        ->assertSuccessful()
        ->assertSeeText('Hello, World');
});

test('the home page displays greeting with custom name', function () {
    $this->get('/?name=John')
        ->assertSuccessful()
        ->assertSeeText('Hello, John');
});

test('the about page returns a successful response', function () {
    $this->get('/about')->assertSuccessful();
});

test('the about page displays the correct heading', function () {
    $this->get('/about')
        ->assertSuccessful()
        ->assertSeeText('About Us');
});

test('the contact page returns a successful response', function () {
    $this->get('/contact')->assertSuccessful();
});

test('the contact page displays the correct heading', function () {
    $this->get('/contact')
        ->assertSuccessful()
        ->assertSeeText('Contact Us');
});

test('the tasks page returns a successful response', function () {
    $this->get('/tasks')->assertSuccessful();
});

test('the tasks page displays the correct heading', function () {
    $this->get('/tasks')
        ->assertSuccessful()
        ->assertSeeText('Tasks');
});

test('the tasks page displays tasks', function () {
    $this->get('/tasks')
        ->assertSuccessful()
        ->assertSeeText('Buy groceries')
        ->assertSeeText('Walk the dog')
        ->assertSeeText('Finish Laravel project');
});
