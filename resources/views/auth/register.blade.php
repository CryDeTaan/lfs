<x-layout title="Register">
    <div class="mx-auto flex min-h-screen max-w-md items-center px-4 py-12">
        <div class="w-full">
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-white">Create an account</h1>
                <p class="mt-2 text-sm text-white/60">
                    Start capturing your ideas today
                </p>
            </div>

            <form
                method="POST"
                action="{{ route('register') }}"
                class="rounded-2xl bg-white/10 p-6 ring-1 ring-white/20 backdrop-blur-lg"
            >
                @csrf

                <div class="space-y-4">
                    <div>
                        <label
                            for="name"
                            class="mb-1 block text-sm font-medium text-white/70"
                        >
                            Name
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            autofocus
                            class="w-full rounded-lg bg-white/20 px-4 py-2 text-white placeholder-white/50 transition focus:bg-white/30 focus:ring-1 focus:ring-white/40 focus:outline-none"
                        />
                        @error('name')
                            <p class="mt-1 text-sm text-red-300">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

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
                            class="w-full rounded-lg bg-white/20 px-4 py-2 text-white placeholder-white/50 transition focus:bg-white/30 focus:ring-1 focus:ring-white/40 focus:outline-none"
                        />
                        @error('email')
                            <p class="mt-1 text-sm text-red-300">
                                {{ $message }}
                            </p>
                        @enderror
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
                        @error('password')
                            <p class="mt-1 text-sm text-red-300">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label
                            for="password_confirmation"
                            class="mb-1 block text-sm font-medium text-white/70"
                        >
                            Confirm Password
                        </label>
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
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
                        Register
                    </x-button>
                </div>
            </form>

            <p class="mt-4 text-center text-sm text-white/60">
                Already have an account?
                <a
                    href="{{ route('login') }}"
                    class="text-amber-400 transition hover:text-amber-300"
                >
                    Log in
                </a>
            </p>
        </div>
    </div>
</x-layout>
