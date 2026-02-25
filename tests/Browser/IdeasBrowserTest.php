<?php

use App\Enums\IdeaState;
use App\Models\Idea;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('the ideas page shows empty state', function () {
    $page = visit('/');

    $page->assertSee('Ideas')
        ->assertSee('No ideas yet');
});

test('a user can create an idea through the browser', function () {
    $page = visit('/');

    $page->fill('description', 'My browser test idea')
        ->press('Save')
        ->assertPathIs('/')
        ->assertSee('My browser test idea');

    $this->assertDatabaseHas('ideas', ['description' => 'My browser test idea']);
});

test('the ideas page displays existing ideas', function () {
    Idea::factory()->for($this->user)->create(['description' => 'First idea']);
    Idea::factory()->for($this->user)->create(['description' => 'Second idea']);

    $page = visit('/');

    $page->assertSee('First idea')
        ->assertSee('Second idea');
});

test('a user can navigate to an idea detail page', function () {
    $idea = Idea::factory()->for($this->user)->create(['description' => 'Clickable idea']);

    $page = visit('/');

    $page->click('Clickable idea')
        ->assertPathIs("/ideas/{$idea->id}")
        ->assertSee('Clickable idea')
        ->assertSee('Pending');
});

test('a user can toggle an idea state from the index page', function () {
    Idea::factory()->for($this->user)->create(['description' => 'Toggle me']);

    $page = visit('/');

    $page->press('button.rounded-full.bg-green-500\\/20')
        ->assertPathIs('/')
        ->assertSee('Reopen');

    $this->assertDatabaseHas('ideas', [
        'description' => 'Toggle me',
        'state' => 'complete',
    ]);
});

test('a user can delete an idea from the show page', function () {
    $idea = Idea::factory()->for($this->user)->create(['description' => 'Delete me']);

    $page = visit("/ideas/{$idea->id}");

    $page->assertSee('Delete me')
        ->press('Delete')
        ->assertPathIs('/');

    $this->assertDatabaseMissing('ideas', ['id' => $idea->id]);
});

test('a user can edit an idea through the browser', function () {
    $idea = Idea::factory()->for($this->user)->create(['description' => 'Old description']);

    $page = visit("/ideas/{$idea->id}");

    $page->click('Edit')
        ->assertPathIs("/ideas/{$idea->id}/edit")
        ->clear('textarea[name="description"]')
        ->type('textarea[name="description"]', 'Updated description')
        ->press('Save')
        ->assertPathIs("/ideas/{$idea->id}")
        ->assertSee('Updated description');

    expect($idea->fresh()->description)->toBe('Updated description');
});

test('a user can cancel editing an idea', function () {
    $idea = Idea::factory()->for($this->user)->create(['description' => 'Keep me']);

    $page = visit("/ideas/{$idea->id}/edit");

    $page->click('Cancel')
        ->assertPathIs("/ideas/{$idea->id}")
        ->assertSee('Keep me');
});

test('a user can toggle idea state from the show page', function () {
    $idea = Idea::factory()->for($this->user)->create(['description' => 'Toggle from show']);

    $page = visit("/ideas/{$idea->id}");

    $page->assertSee('Pending')
        ->press('Mark Complete')
        ->assertSee('Complete')
        ->assertSee('Reopen');

    expect($idea->fresh()->state)->toBe(IdeaState::Complete);
});

test('filtering by pending state shows only pending ideas', function () {
    Idea::factory()->for($this->user)->create(['description' => 'Pending idea', 'state' => IdeaState::Pending]);
    Idea::factory()->for($this->user)->complete()->create(['description' => 'Complete idea']);

    $page = visit('/');

    $page->click('Pending')
        ->assertSee('Pending idea')
        ->assertDontSee('Complete idea');
});

test('filtering by complete state shows only complete ideas', function () {
    Idea::factory()->for($this->user)->create(['description' => 'Pending idea', 'state' => IdeaState::Pending]);
    Idea::factory()->for($this->user)->complete()->create(['description' => 'Complete idea']);

    $page = visit('/');

    $page->click('Complete')
        ->assertSee('Complete idea')
        ->assertDontSee('Pending idea');
});

test('the back to ideas link works from the show page', function () {
    $idea = Idea::factory()->for($this->user)->create(['description' => 'Navigate back']);

    $page = visit("/ideas/{$idea->id}");

    $page->click("\u{2190} Back to Ideas")
        ->assertPathIs('/');
});
