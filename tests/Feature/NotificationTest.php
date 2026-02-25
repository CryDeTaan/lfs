<?php

use App\Models\Idea;
use App\Models\User;
use App\Notifications\IdeaPublished;
use Illuminate\Support\Facades\Notification;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('creating an idea dispatches an IdeaPublished notification', function () {
    Notification::fake();

    $this->post('/ideas', ['description' => 'My notified idea'])
        ->assertRedirect();

    Notification::assertSentTo($this->user, IdeaPublished::class);
});

test('the notifications page returns a successful response', function () {
    $this->get('/notifications')
        ->assertSuccessful();
});

test('the notifications page shows the users notifications', function () {
    $idea = Idea::factory()->for($this->user)->create(['description' => 'Test idea']);
    $this->user->notify(new IdeaPublished($idea));

    $this->get('/notifications')
        ->assertSuccessful()
        ->assertSeeText('Your idea was published')
        ->assertSeeText('Test idea');
});

test('a user cannot see another users notifications', function () {
    $otherUser = User::factory()->create();
    $idea = Idea::factory()->for($otherUser)->create();
    $otherUser->notify(new IdeaPublished($idea));

    $this->get('/notifications')
        ->assertSuccessful()
        ->assertDontSeeText('Your idea was published');
});

test('a user can mark a notification as read', function () {
    $idea = Idea::factory()->for($this->user)->create();
    $this->user->notify(new IdeaPublished($idea));

    $notification = $this->user->unreadNotifications->first();

    $this->patch("/notifications/{$notification->id}/read")
        ->assertRedirect();

    expect($notification->fresh()->read_at)->not->toBeNull();
});

test('a user cannot mark another users notification as read', function () {
    $otherUser = User::factory()->create();
    $idea = Idea::factory()->for($otherUser)->create();
    $otherUser->notify(new IdeaPublished($idea));

    $notification = $otherUser->unreadNotifications->first();

    $this->patch("/notifications/{$notification->id}/read")
        ->assertNotFound();
});
