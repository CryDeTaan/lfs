<?php

use App\Models\Idea;
use App\Models\User;
use App\Notifications\IdeaPublished;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('a user can navigate to the notifications page', function () {
    $page = visit('/');

    $page->navigate('/notifications')
        ->assertPathIs('/notifications')
        ->assertSee('Notifications');
});

test('notifications page shows empty state', function () {
    $page = visit('/notifications');

    $page->assertSee('No notifications yet');
});

test('notifications page shows user notifications', function () {
    $idea = Idea::factory()->for($this->user)->create(['description' => 'Notified idea']);
    $this->user->notify(new IdeaPublished($idea));

    $page = visit('/notifications');

    $page->assertSee('Your idea was published')
        ->assertSee('Notified idea');
});

test('a user can mark a notification as read', function () {
    $idea = Idea::factory()->for($this->user)->create(['description' => 'Read me']);
    $this->user->notify(new IdeaPublished($idea));

    $page = visit('/notifications');

    $page->assertSee('Mark as read')
        ->press('Mark as read')
        ->assertPathIs('/notifications');

    expect($this->user->fresh()->unreadNotifications)->toBeEmpty();
});
