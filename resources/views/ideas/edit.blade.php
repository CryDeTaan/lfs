<x-layout title="Edit Idea">
    <div class="mx-auto max-w-2xl px-4 py-12">
        <div class="mb-6">
            <a
                href="{{ route('ideas.index') }}"
                class="inline-flex items-center gap-1 text-sm text-white/60 transition hover:text-white"
            >
                &larr; Back to Ideas
            </a>
        </div>

        <form method="POST" action="{{ route('ideas.update', $idea) }}">
            @csrf
            @method('PATCH')

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
                </div>

                <div class="mt-4">
                    <textarea
                        name="description"
                        rows="3"
                        class="w-full rounded-xl bg-white/10 px-4 py-3 text-lg text-white placeholder-white/40 ring-1 ring-white/20 focus:ring-2 focus:ring-white/40 focus:outline-none"
                    >
{{ old('description', $idea->description) }}</textarea
                    >

                    @error('description')
                        <p class="mt-1 text-sm text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <div
                    class="flex items-start justify-between border-t border-white/10 pt-2"
                >
                    <p class="text-sm leading-none text-white/40">
                        Created {{ $idea->created_at->diffForHumans() }}
                    </p>

                    <div class="flex items-baseline gap-2">
                        <a
                            href="{{ route('ideas.show', $idea) }}"
                            class="text-sm text-white/60 transition hover:text-white"
                        >
                            Cancel
                        </a>

                        <x-button type="submit" variant="primary">
                            Save
                        </x-button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-layout>
