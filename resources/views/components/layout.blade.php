@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>
            {{ $title ? $title.' - ' : '' }}{{ config('app.name', 'Laravel') }}
        </title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body
        class="min-h-screen bg-gradient-to-br from-violet-600 via-purple-500 to-indigo-600 text-white antialiased"
    >
        <header
            class="mx-auto flex max-w-2xl items-center justify-between px-4 pt-6"
        >
            <a
                href="{{ route('ideas.index') }}"
                class="text-lg font-bold text-white"
            >
                {{ config('app.name', 'LFS') }}
            </a>

            @auth
                <div class="flex items-center gap-3">
                    <span class="text-sm text-white/60">
                        {{ Auth::user()->name }}
                    </span>
                    <a
                        href="{{ route('notifications.index') }}"
                        class="relative text-white/70 transition hover:text-white"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="h-5 w-5"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0"
                            />
                        </svg>
                        @if (Auth::user()->unreadNotifications->count())
                            <span
                                class="absolute -top-1.5 -right-1.5 flex h-4 w-4 items-center justify-center rounded-full bg-amber-400 text-[10px] font-bold text-gray-900"
                            >
                                {{ Auth::user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-button type="submit">Logout</x-button>
                    </form>
                </div>
            @else
                <div class="flex items-center gap-2">
                    <x-button :href="route('login')">Log in</x-button>
                    <x-button :href="route('register')" variant="primary">
                        Register
                    </x-button>
                </div>
            @endauth
        </header>

        {{ $slot }}
    </body>
</html>
