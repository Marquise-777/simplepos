<x-guest-layout>

    <div class="mb-8 text-center">

        <h2 class="text-3xl font-bold text-slate-800">
            Reset Password 🔑
        </h2>

        <p class="mt-2 text-slate-500">
            Create a new password for your SIMPOS account.
        </p>

    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <x-input label="Email Address" name="email" type="email" :value="old('email', $request->email)" placeholder="you@example.com"
            required autofocus autocomplete="username" />

        <x-input label="New Password" name="password" type="password" placeholder="••••••••" required
            autocomplete="new-password" />

        <x-input label="Confirm Password" name="password_confirmation" type="password" placeholder="••••••••" required
            autocomplete="new-password" />

        <x-button type="submit" size="lg" full>

            Reset Password

        </x-button>

    </form>

    <div class="mt-8 text-center text-sm text-slate-500">

        Remember your password?

        <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-700">

            Back to Login

        </a>

    </div>

</x-guest-layout>
