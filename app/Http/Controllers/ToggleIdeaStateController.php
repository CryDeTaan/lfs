<?php

namespace App\Http\Controllers;

use App\Enums\IdeaState;
use App\Models\Idea;
use Illuminate\Http\RedirectResponse;

class ToggleIdeaStateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Idea $idea): RedirectResponse
    {
        $idea->update([
            'state' => $idea->state === IdeaState::Pending
                ? IdeaState::Complete
                : IdeaState::Pending,
        ]);

        return redirect()->back();
    }
}
