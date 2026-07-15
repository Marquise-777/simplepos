<x-guest-layout>

    <div class="mb-8 text-center">

        <h2 class="text-3xl font-bold text-slate-800">
            Confirm Password 🔒
        </h2>

        <p class="mt-2 text-slate-500">
            This is a secure area. Please confirm your password to continue.
        </p>

    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

        <x-input label="Password" name="password" type="password" placeholder="••••••••" required autofocus
            autocomplete="current-password" />

        <x-button type="submit" size="lg" full>

            Confirm Password

        </x-button>

    </form>

    <div class="mt-8 text-center text-sm text-slate-500">

        <a href="{{ route('dashboard') }}" class="font-semibold text-blue-600 hover:text-blue-700">

            ← Back to Dashboard

        </a>

    </div>

</x-guest-layout>
