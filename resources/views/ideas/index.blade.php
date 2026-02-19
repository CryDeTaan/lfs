<x-layout title="Ideas">
    <div class="mx-auto max-w-2xl px-4 py-12">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-3xl font-bold text-white">Ideas</h1>
            <div class="flex items-center gap-2">
                @if (count($ideas))
                    <form method="POST" action="{{ route('ideas.clear') }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="rounded-full bg-red-500/20 px-4 py-2 text-sm font-medium text-red-300 ring-1 ring-red-400/30 transition hover:bg-red-500/30">
                            Clear All
                        </button>
                    </form>
                @endif
                <a
                    href="{{ route('old.home') }}"
                    class="rounded-full bg-white/15 px-4 py-2 text-sm font-medium text-white transition hover:bg-white/25"
                >
                    Old Pages
                </a>
            </div>
        </div>

        <form method="POST" action="{{ route('ideas.store') }}" class="mb-8 rounded-2xl bg-white/10 p-6 ring-1 ring-white/20 backdrop-blur-lg">
            @csrf
            <div class="flex gap-3">
                <input
                    type="text"
                    name="idea"
                    placeholder="What's your idea?"
                    value="{{ old('idea') }}"
                    class="grow rounded-lg bg-white/20 px-4 py-2 text-white placeholder-white/50 transition focus:bg-white/30 focus:outline-none focus:ring-1 focus:ring-white/40"
                />
                <button
                    type="submit"
                    class="rounded-lg bg-amber-400 px-6 py-2 font-medium text-gray-900 transition hover:bg-amber-300"
                >
                    Save
                </button>
            </div>
            @error('idea')
                <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
            @enderror
        </form>

        @forelse ($ideas as $idea)
            @if ($loop->first)
                <ul class="space-y-3">
            @endif

            <li class="rounded-xl border-l-4 border-amber-400 bg-white/10 px-4 py-3 backdrop-blur transition hover:-translate-y-0.5 hover:bg-white/15">{{ $idea }}</li>

            @if ($loop->last)
                </ul>
            @endif
        @empty
            <div class="rounded-xl border-2 border-dashed border-white/20 bg-white/5 px-4 py-8 text-center text-white/60">
                No ideas yet. Add one above!
            </div>
        @endforelse
    </div>
</x-layout>
