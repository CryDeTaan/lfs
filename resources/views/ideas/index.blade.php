<x-layout title="Ideas">
    <div class="mx-auto max-w-2xl px-4 py-12">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-3xl font-bold text-white">Ideas</h1>
            <div class="flex items-center gap-2">
                <a
                    href="{{ route('old.home') }}"
                    class="rounded-full bg-white/15 px-4 py-2 text-sm font-medium text-white transition hover:bg-white/25"
                >
                    Old Pages
                </a>
            </div>
        </div>

        <div class="mb-6 flex gap-2">
            <a
                href="{{ route('ideas.index') }}"
                @class([
                    'rounded-full px-4 py-1.5 text-sm font-medium transition',
                    'bg-amber-400 text-gray-900' => ! $currentState,
                    'bg-white/10 text-white hover:bg-white/20' => $currentState,
                ])
            >
                All
            </a>
            <a
                href="{{ route('ideas.index', ['state' => 'pending']) }}"
                @class([
                    'rounded-full px-4 py-1.5 text-sm font-medium transition',
                    'bg-amber-400 text-gray-900' => $currentState === 'pending',
                    'bg-white/10 text-white hover:bg-white/20' => $currentState !== 'pending',
                ])
            >
                Pending
            </a>
            <a
                href="{{ route('ideas.index', ['state' => 'complete']) }}"
                @class([
                    'rounded-full px-4 py-1.5 text-sm font-medium transition',
                    'bg-amber-400 text-gray-900' => $currentState === 'complete',
                    'bg-white/10 text-white hover:bg-white/20' => $currentState !== 'complete',
                ])
            >
                Complete
            </a>
        </div>

        <form
            method="POST"
            action="{{ route('ideas.store') }}"
            class="mb-8 rounded-2xl bg-white/10 p-6 ring-1 ring-white/20 backdrop-blur-lg"
        >
            @csrf
            <div class="flex gap-3">
                <input
                    type="text"
                    name="idea"
                    placeholder="What's your idea?"
                    value="{{ old('idea') }}"
                    class="grow rounded-lg bg-white/20 px-4 py-2 text-white placeholder-white/50 transition focus:bg-white/30 focus:ring-1 focus:ring-white/40 focus:outline-none"
                />
                <x-button type="submit" variant="primary">Save</x-button>
            </div>
            @error('idea')
                <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
            @enderror
        </form>

        @if (count($ideas))
            <ul class="space-y-3">
                @foreach ($ideas as $idea)
                    <li
                        @class([
                            'flex items-center justify-between rounded-xl border-l-4 bg-white/10 px-4 py-3 backdrop-blur transition hover:-translate-y-0.5 hover:bg-white/15',
                            'border-amber-400' => $idea->state === \App\Enums\IdeaState::Pending,
                            'border-green-400' => $idea->state === \App\Enums\IdeaState::Complete,
                        ])
                    >
                        <a
                            href="{{ route('ideas.show', $idea) }}"
                            @class([
                                'transition hover:text-amber-300',
                                'line-through opacity-60' => $idea->state === \App\Enums\IdeaState::Complete,
                            ])
                        >
                            {{ $idea->description }}
                        </a>
                        <form
                            method="POST"
                            action="{{ route('ideas.state', $idea) }}"
                        >
                            @csrf
                            @method('PATCH')
                            <x-badge
                                type="submit"
                                class="shrink-0"
                                :color="$idea->state === \App\Enums\IdeaState::Pending ? 'green' : 'amber'"
                            >
                                {{ $idea->state === \App\Enums\IdeaState::Pending ? 'Complete' : 'Reopen' }}
                            </x-badge>
                        </form>
                    </li>
                @endforeach
            </ul>
        @else
            <div
                class="rounded-xl border-2 border-dashed border-white/20 bg-white/5 px-4 py-8 text-center text-white/60"
            >
                No ideas yet. Add one above!
            </div>
        @endif
    </div>
</x-layout>
