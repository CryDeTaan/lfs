<?php

use App\Enums\IdeaState;
use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    $query = Idea::query()->latest();

    $state = $request->query('state');

    if ($state && IdeaState::tryFrom($state)) {
        $query->where('state', $state);
    }

    $ideas = $query->get();

    return view('ideas.index', ['ideas' => $ideas, 'currentState' => $state]);
})->name('ideas.index');

Route::get('/ideas/{idea}', function (Idea $idea) {
    return view('ideas.show', ['idea' => $idea]);
})->name('ideas.show');

Route::post('/ideas', function (Request $request) {
    $validated = $request->validate([
        'idea' => ['required', 'string', 'max:255'],
    ]);

    Idea::query()->create(['description' => $validated['idea']]);

    return redirect()->back();
})->name('ideas.store');

Route::patch('/ideas/{idea}/state', function (Idea $idea) {
    $idea->update([
        'state' => $idea->state === IdeaState::Pending
            ? IdeaState::Complete
            : IdeaState::Pending,
    ]);

    return redirect()->back();
})->name('ideas.state');

Route::delete('/ideas', function () {
    Idea::query()->truncate();

    return redirect()->back();
})->name('ideas.clear');

require __DIR__.'/old.php';
