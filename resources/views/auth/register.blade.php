<x-guest-layout>

    <div class="mb-8 text-center">

        <h2 class="text-3xl font-bold text-slate-800">
            Create Account ✨
        </h2>

        <p class="mt-2 text-slate-500">
            Create your SIMPOS account to get started.
        </p>

    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <x-input label="Full Name" name="name" placeholder="John Doe" :value="old('name')" required autofocus
            autocomplete="name" />

        <x-input label="Email Address" name="email" type="email" placeholder="you@example.com" :value="old('email')"
            required autocomplete="username" />

        <x-input label="Password" name="password" type="password" placeholder="••••••••" required
            autocomplete="new-password" />

        <x-input label="Confirm Password" name="password_confirmation" type="password" placeholder="••••••••" required
            autocomplete="new-password" />

        <x-button type="submit" size="lg" full>

            Create Account

        </x-button>

    </form>

    <div class="mt-8 text-center text-sm text-slate-500">

        Already have an account?

        <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-700">

            Sign In

        </a>

    </div>

</x-guest-layout>
