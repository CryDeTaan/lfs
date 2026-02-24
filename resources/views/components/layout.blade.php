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
