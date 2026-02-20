<?php

use App\Models\Idea;

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

    $this->assertDatabaseHas('ideas', ['description' => 'My great idea']);

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

test('the ideas page displays ideas from the database', function () {
    Idea::factory()->create(['description' => 'First idea']);
    Idea::factory()->create(['description' => 'Second idea']);

    $this->get('/')
        ->assertSeeText('First idea')
        ->assertSeeText('Second idea');
});

test('the ideas page shows empty state when no ideas exist', function () {
    $this->get('/')
        ->assertSeeText('No ideas yet');
});

test('a user can clear all ideas', function () {
    Idea::factory()->count(3)->create();

    $this->delete('/ideas')
        ->assertRedirect();

    $this->assertDatabaseCount('ideas', 0);
});
