<x-layout title="Notifications">
    <div class="mx-auto max-w-2xl px-4 py-12">
        <h1 class="mb-6 text-3xl font-bold text-white">Notifications</h1>

        @if ($notifications->count())
            <ul class="space-y-3">
                @foreach ($notifications as $notification)
                    <li
                        @class([
                            'flex items-center justify-between rounded-xl bg-white/10 px-4 py-3 backdrop-blur',
                            'border-l-4 border-amber-400' => ! $notification->read_at,
                            'opacity-60' => $notification->read_at,
                        ])
                    >
                        <div>
                            <p class="font-medium text-white">
                                {{ $notification->data['message'] }}
                            </p>
                            <p class="text-sm text-white/60">
                                {{ $notification->data['description'] }}
                            </p>
                            <p class="mt-1 text-xs text-white/40">
                                {{ $notification->created_at->diffForHumans() }}
                            </p>
                        </div>
                        @unless ($notification->read_at)
                            <form
                                method="POST"
                                action="{{ route('notifications.read', $notification->id) }}"
                            >
                                @csrf
                                @method('PATCH')
                                <x-button type="submit">Mark as read</x-button>
                            </form>
                        @endunless
                    </li>
                @endforeach
            </ul>
        @else
            <div
                class="rounded-xl border-2 border-dashed border-white/20 bg-white/5 px-4 py-8 text-center text-white/60"
            >
                No notifications yet.
            </div>
        @endif
    </div>
</x-layout>
