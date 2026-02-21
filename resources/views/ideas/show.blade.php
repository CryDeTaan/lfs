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
            <div class="flex items-center justify-between">
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

            <p class="mt-3 text-sm text-white/40">
                Created {{ $idea->created_at->diffForHumans() }}
            </p>

            <div
                class="mt-5 flex items-center gap-2 border-t border-white/10 pt-5"
            >
                <x-button :href="route('ideas.edit', $idea)" variant="primary">
                    Edit
                </x-button>

                <form
                    method="POST"
                    action="{{ route('ideas.destroy', $idea) }}"
                    class="ml-auto"
                >
                    @csrf
                    @method('DELETE')
                    <x-button type="submit" variant="danger">Delete</x-button>
                </form>
            </div>
        </div>
    </div>
</x-layout>
