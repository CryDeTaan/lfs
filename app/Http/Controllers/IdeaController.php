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
        $query = Idea::query()->latest();

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

        Idea::query()->create([
            'description' => $request['description'],
        ]);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Idea $idea): View
    {
        return view('ideas.show', ['idea' => $idea]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Idea $idea): View
    {
        return view('ideas.edit', ['idea' => $idea]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIdeaRequest $request, Idea $idea): RedirectResponse
    {
        $idea->update([
            'description' => $request['description'],
            'state' => $request['state'],
        ]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Idea $idea): RedirectResponse
    {
        $idea->delete();

        return redirect()->route('ideas.index');
    }
}
