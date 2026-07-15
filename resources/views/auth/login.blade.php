<x-guest-layout>

    <div class="mb-8 text-center">

        <h2 class="text-3xl font-bold text-slate-800">
            Welcome Back 👋
        </h2>

        <p class="mt-2 text-slate-500">
            Sign in to continue to your dashboard.
        </p>

    </div>

    @if (session('status'))
        <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <x-input label="Email Address" name="email" type="email" placeholder="you@example.com" :value="old('email')"
            required autofocus autocomplete="username" />

        <x-input label="Password" name="password" type="password" placeholder="••••••••" required
            autocomplete="current-password" />

        <div class="flex items-center justify-between">

            <label class="flex items-center gap-2 text-sm text-slate-600">

                <input type="checkbox" name="remember"
                    class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">

                Remember me

            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700">
                    Forgot Password?
                </a>
            @endif

        </div>

        <x-button type="submit" size="lg" full>

            Sign In

        </x-button>

    </form>

    <div class="mt-8 text-center text-sm text-slate-500">

        Don't have an account?

        <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:text-blue-700">

            Create one

        </a>

    </div>

</x-guest-layout>
