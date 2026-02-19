<?php

test('the ideas page returns a successful response', function () {
    $this->get('/')
        ->assertSuccessful()
        ->assertSeeText('Ideas');
});

test('the ideas page shows the form', function () {
    $this->get('/')
        ->assertSuccessful()
        ->assertSee('Save');
});

test('a user can store an idea', function () {
    $this->post('/ideas', ['idea' => 'My great idea'])
        ->assertRedirect();

    $this->get('/')
        ->assertSeeText('My great idea');
});

test('storing an idea requires the idea field', function () {
    $this->post('/ideas', ['idea' => ''])
        ->assertSessionHasErrors('idea');
});

test('storing an idea enforces max length', function () {
    $this->post('/ideas', ['idea' => str_repeat('a', 256)])
        ->assertSessionHasErrors('idea');
});

test('the ideas page displays ideas from session', function () {
    $this->withSession(['ideas' => ['First idea', 'Second idea']])
        ->get('/')
        ->assertSeeText('First idea')
        ->assertSeeText('Second idea');
});

test('the ideas page shows empty state when no ideas exist', function () {
    $this->get('/')
        ->assertSeeText('No ideas yet');
});
