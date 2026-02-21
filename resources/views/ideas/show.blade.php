<x-layout title="Idea">
    <div class="mx-auto max-w-2xl px-4 py-12">
        <div class="mb-6">
            <a
                href="{{ route('ideas.index') }}"
                class="inline-flex items-center gap-1 text-sm text-white/60 transition hover:text-white"
            >
                &larr; Back to Ideas
            </a>
        </div>

        <div
            @class([
                'rounded-2xl border-l-4 bg-white/10 p-6 ring-1 ring-white/20 backdrop-blur-lg',
                'border-amber-400' => $idea->state === \App\Enums\IdeaState::Pending,
                'border-green-400' => $idea->state === \App\Enums\IdeaState::Complete,
            ])
        >
            <div class="mb-4 flex items-center justify-between">
                <span
                    @class([
                        'rounded-full px-3 py-1 text-xs font-medium',
                        'bg-amber-500/20 text-amber-300 ring-1 ring-amber-400/30' => $idea->state === \App\Enums\IdeaState::Pending,
                        'bg-green-500/20 text-green-300 ring-1 ring-green-400/30' => $idea->state === \App\Enums\IdeaState::Complete,
                    ])
                >
                    {{ $idea->state === \App\Enums\IdeaState::Pending ? 'Pending' : 'Complete' }}
                </span>

                <div class="flex items-center gap-2">
                    <a
                        href="{{ route('ideas.edit', $idea) }}"
                        class="rounded-full bg-white/10 px-4 py-1.5 text-sm font-medium text-white/70 ring-1 ring-white/20 transition hover:bg-white/20 hover:text-white"
                    >
                        Edit
                    </a>

                    <form
                        method="POST"
                        action="{{ route('ideas.state', $idea) }}"
                    >
                        @csrf
                        @method('PATCH')
                        <button
                            type="submit"
                            @class([
                                'rounded-full px-4 py-1.5 text-sm font-medium transition',
                                'bg-green-500/20 text-green-300 ring-1 ring-green-400/30 hover:bg-green-500/30' => $idea->state === \App\Enums\IdeaState::Pending,
                                'bg-amber-500/20 text-amber-300 ring-1 ring-amber-400/30 hover:bg-amber-500/30' => $idea->state === \App\Enums\IdeaState::Complete,
                            ])
                        >
                            {{ $idea->state === \App\Enums\IdeaState::Pending ? 'Mark Complete' : 'Reopen' }}
                        </button>
                    </form>
                </div>
            </div>

            <p
                @class([
                    'text-lg text-white',
                    'line-through opacity-60' => $idea->state === \App\Enums\IdeaState::Complete,
                ])
            >
                {{ $idea->description }}
            </p>

            <p class="mt-4 text-sm text-white/40">
                Created {{ $idea->created_at->diffForHumans() }}
            </p>
        </div>
    </div>
</x-layout>
