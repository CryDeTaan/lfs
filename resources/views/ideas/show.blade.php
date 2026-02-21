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
            <div class="flex items-start justify-between">
                <x-badge
                    :color="$idea->state === \App\Enums\IdeaState::Pending ? 'amber' : 'green'"
                >
                    {{ $idea->state === \App\Enums\IdeaState::Pending ? 'Pending' : 'Complete' }}
                </x-badge>

                <form method="POST" action="{{ route('ideas.state', $idea) }}">
                    @csrf
                    @method('PATCH')
                    <x-badge
                        type="submit"
                        :color="$idea->state === \App\Enums\IdeaState::Pending ? 'green' : 'amber'"
                    >
                        {{ $idea->state === \App\Enums\IdeaState::Pending ? 'Mark Complete' : 'Reopen' }}
                    </x-badge>
                </form>
            </div>

            <p
                @class([
                    'mt-4 text-lg text-white',
                    'line-through opacity-60' => $idea->state === \App\Enums\IdeaState::Complete,
                ])
            >
                {{ $idea->description }}
            </p>

            <div
                class="flex items-start justify-between border-t border-white/10 pt-2"
            >
                <p class="text-sm leading-none text-white/40">
                    Created {{ $idea->created_at->diffForHumans() }}
                </p>

                <div class="flex gap-2">
                    <form
                        method="POST"
                        action="{{ route('ideas.destroy', $idea) }}"
                    >
                        @csrf
                        @method('DELETE')
                        <x-button type="submit" variant="danger">
                            Delete
                        </x-button>
                    </form>

                    <x-button
                        :href="route('ideas.edit', $idea)"
                        variant="primary"
                    >
                        Edit
                    </x-button>
                </div>
            </div>
        </div>
    </div>
</x-layout>
