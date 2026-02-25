<?php

use App\Models\Idea;
use App\Models\User;

test('guest pages have no smoke', function () {
    visit(['/login', '/register'])->assertNoSmoke();
});

test('authenticated pages have no smoke', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $idea = Idea::factory()->for($user)->create();

    visit(['/', "/ideas/{$idea->id}", "/ideas/{$idea->id}/edit", '/notifications'])
        ->assertNoSmoke();
});
