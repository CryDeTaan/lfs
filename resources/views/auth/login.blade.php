<x-layout title="Log in">
    <div class="mx-auto flex min-h-screen max-w-md items-center px-4 py-12">
        <div class="w-full">
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-white">Welcome back</h1>
                <p class="mt-2 text-sm text-white/60">
                    Log in to manage your ideas
                </p>
            </div>

            <form
                method="POST"
                action="{{ route('login') }}"
                class="rounded-2xl bg-white/10 p-6 ring-1 ring-white/20 backdrop-blur-lg"
            >
                @csrf

                @if ($errors->has('email') && ! old('email_input_error'))
                    <div
                        class="mb-4 rounded-lg bg-red-500/20 px-4 py-3 text-sm text-red-300 ring-1 ring-red-400/30"
                    >
                        {{ $errors->first('email') }}
                    </div>
                @endif

                <div class="space-y-4">
                    <div>
                        <label
                            for="email"
                            class="mb-1 block text-sm font-medium text-white/70"
                        >
                            Email
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            class="w-full rounded-lg bg-white/20 px-4 py-2 text-white placeholder-white/50 transition focus:bg-white/30 focus:ring-1 focus:ring-white/40 focus:outline-none"
                        />
                    </div>

                    <div>
                        <label
                            for="password"
                            class="mb-1 block text-sm font-medium text-white/70"
                        >
                            Password
                        </label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            class="w-full rounded-lg bg-white/20 px-4 py-2 text-white placeholder-white/50 transition focus:bg-white/30 focus:ring-1 focus:ring-white/40 focus:outline-none"
                        />
                    </div>
                </div>

                <div class="mt-6">
                    <x-button
                        type="submit"
                        variant="primary"
                        class="w-full justify-center py-2.5"
                    >
                        Log in
                    </x-button>
                </div>
            </form>

            <p class="mt-4 text-center text-sm text-white/60">
                Don't have an account?
                <a
                    href="{{ route('register') }}"
                    class="text-amber-400 transition hover:text-amber-300"
                >
                    Register
                </a>
            </p>
        </div>
    </div>
</x-layout>
