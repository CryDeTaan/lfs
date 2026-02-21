<?php

use App\Enums\IdeaState;
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

test('a user can delete an idea from the show page', function () {
    $idea = Idea::factory()->create(['description' => 'Delete me']);

    $this->delete("/ideas/{$idea->id}")
        ->assertRedirect(route('ideas.index'));

    $this->assertDatabaseMissing('ideas', ['id' => $idea->id]);
});

test('the idea show page has a delete button', function () {
    $idea = Idea::factory()->create();

    $this->get("/ideas/{$idea->id}")
        ->assertSuccessful()
        ->assertSee(route('ideas.destroy', $idea));
});

test('a new idea has pending state by default', function () {
    $this->post('/ideas', ['idea' => 'A fresh idea']);

    $this->assertDatabaseHas('ideas', [
        'description' => 'A fresh idea',
        'state' => 'pending',
    ]);
});

test('filtering by pending state shows only pending ideas', function () {
    Idea::factory()->create(['description' => 'Pending idea', 'state' => IdeaState::Pending]);
    Idea::factory()->complete()->create(['description' => 'Complete idea']);

    $this->get('/?state=pending')
        ->assertSeeText('Pending idea')
        ->assertDontSeeText('Complete idea');
});

test('filtering by complete state shows only complete ideas', function () {
    Idea::factory()->create(['description' => 'Pending idea', 'state' => IdeaState::Pending]);
    Idea::factory()->complete()->create(['description' => 'Complete idea']);

    $this->get('/?state=complete')
        ->assertSeeText('Complete idea')
        ->assertDontSeeText('Pending idea');
});

test('no filter shows all ideas', function () {
    Idea::factory()->create(['description' => 'Pending idea', 'state' => IdeaState::Pending]);
    Idea::factory()->complete()->create(['description' => 'Complete idea']);

    $this->get('/')
        ->assertSeeText('Pending idea')
        ->assertSeeText('Complete idea');
});

test('a user can toggle an idea state from pending to complete', function () {
    $idea = Idea::factory()->create();

    $this->patch("/ideas/{$idea->id}/state")
        ->assertRedirect();

    expect($idea->fresh()->state)->toBe(IdeaState::Complete);
});

test('the ideas index links to individual idea pages', function () {
    $idea = Idea::factory()->create(['description' => 'Linked idea']);

    $this->get('/')
        ->assertSuccessful()
        ->assertSee(route('ideas.show', $idea));
});

test('a user can view an individual idea', function () {
    $idea = Idea::factory()->create(['description' => 'My brilliant idea']);

    $this->get("/ideas/{$idea->id}")
        ->assertSuccessful()
        ->assertSeeText('My brilliant idea');
});

test('viewing an idea shows its state', function () {
    $idea = Idea::factory()->complete()->create(['description' => 'Done idea']);

    $this->get("/ideas/{$idea->id}")
        ->assertSuccessful()
        ->assertSeeText('Complete');
});

test('viewing a nonexistent idea returns 404', function () {
    $this->get('/ideas/999')
        ->assertNotFound();
});

test('a user can toggle an idea state from complete to pending', function () {
    $idea = Idea::factory()->complete()->create();

    $this->patch("/ideas/{$idea->id}/state")
        ->assertRedirect();

    expect($idea->fresh()->state)->toBe(IdeaState::Pending);
});

test('the idea show page has an edit button', function () {
    $idea = Idea::factory()->create(['description' => 'My editable idea']);

    $this->get("/ideas/{$idea->id}")
        ->assertSuccessful()
        ->assertSee(route('ideas.edit', $idea));
});

test('a user can view the edit page for an idea', function () {
    $idea = Idea::factory()->create(['description' => 'Original description']);

    $this->get("/ideas/{$idea->id}/edit")
        ->assertSuccessful()
        ->assertSee('Original description');
});

test('a user can update an idea description', function () {
    $idea = Idea::factory()->create(['description' => 'Old description']);

    $this->patch("/ideas/{$idea->id}", ['description' => 'Updated description'])
        ->assertRedirect(route('ideas.show', $idea));

    expect($idea->fresh()->description)->toBe('Updated description');
});

test('updating an idea requires the description field', function () {
    $idea = Idea::factory()->create();

    $this->patch("/ideas/{$idea->id}", ['description' => ''])
        ->assertSessionHasErrors('description');
});

test('the edit page mirrors the show page layout', function () {
    $idea = Idea::factory()->create(['description' => 'Layout test idea']);

    $this->get("/ideas/{$idea->id}/edit")
        ->assertSuccessful()
        ->assertSeeText('Pending')
        ->assertSeeText('Created')
        ->assertSee(route('ideas.show', $idea))
        ->assertSeeText('Cancel')
        ->assertSeeText('Save');
});

test('updating an idea enforces max length', function () {
    $idea = Idea::factory()->create();

    $this->patch("/ideas/{$idea->id}", ['description' => str_repeat('a', 256)])
        ->assertSessionHasErrors('description');
});
