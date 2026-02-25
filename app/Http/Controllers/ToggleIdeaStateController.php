<?php

namespace App\Http\Controllers;

use App\Enums\IdeaState;
use App\Models\Idea;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ToggleIdeaStateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Idea $idea): RedirectResponse
    {
        Gate::authorize('update', $idea);

        $idea->update([
            'state' => $idea->state === IdeaState::Pending
                ? IdeaState::Complete
                : IdeaState::Pending,
        ]);

        return redirect()->back();
    }
}
