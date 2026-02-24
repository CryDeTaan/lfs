<?php

namespace App\Http\Controllers;

use App\Enums\IdeaState;
use App\Http\Requests\StoreIdeaRequest;
use App\Http\Requests\UpdateIdeaRequest;
use App\Models\Idea;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = $request->user()->ideas()->latest();

        $state = $request->query('state');

        if ($state && IdeaState::tryFrom($state)) {
            $query->where('state', $state);
        }

        $ideas = $query->get();

        return view('ideas.index', ['ideas' => $ideas, 'currentState' => $state]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIdeaRequest $request): RedirectResponse
    {
        $request->user()->ideas()->create($request->validated());

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Idea $idea): View
    {
        abort_unless($idea->user_id === $request->user()->id, 403);

        return view('ideas.show', ['idea' => $idea]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Idea $idea): View
    {
        abort_unless($idea->user_id === $request->user()->id, 403);

        return view('ideas.edit', ['idea' => $idea]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIdeaRequest $request, Idea $idea): RedirectResponse
    {
        abort_unless($idea->user_id === $request->user()->id, 403);

        $idea->update($request->validated());

        return redirect()->route('ideas.show', $idea);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Idea $idea): RedirectResponse
    {
        abort_unless($idea->user_id === $request->user()->id, 403);

        $idea->delete();

        return redirect()->route('ideas.index');
    }
}
