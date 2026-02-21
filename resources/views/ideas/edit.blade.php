<x-layout title="Edit Idea">
    <div class="mx-auto max-w-2xl px-4 py-12">
        <div class="mb-6">
            <a
                href="{{ route('ideas.show', $idea) }}"
                class="inline-flex items-center gap-1 text-sm text-white/60 transition hover:text-white"
            >
                &larr; Back to Idea
            </a>
        </div>

        <div
            @class([
                'rounded-2xl border-l-4 bg-white/10 p-6 ring-1 ring-white/20 backdrop-blur-lg',
                'border-amber-400' => $idea->state === \App\Enums\IdeaState::Pending,
                'border-green-400' => $idea->state === \App\Enums\IdeaState::Complete,
            ])
        >
            <h2 class="mb-4 text-lg font-semibold text-white">Edit Idea</h2>

            <form method="POST" action="{{ route('ideas.update', $idea) }}">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <textarea
                        name="description"
                        rows="3"
                        class="w-full rounded-xl bg-white/10 px-4 py-3 text-white placeholder-white/40 ring-1 ring-white/20 focus:ring-2 focus:ring-white/40 focus:outline-none"
                    >
{{ old('description', $idea->description) }}</textarea
                    >

                    @error('description')
                        <p class="mt-1 text-sm text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-3">
                    <x-button type="submit" variant="primary">Save</x-button>
                    <a
                        href="{{ route('ideas.show', $idea) }}"
                        class="text-sm text-white/60 transition hover:text-white"
                    >
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layout>
