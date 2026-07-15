<x-guest-layout>

    <div class="mb-8 text-center">

        <h2 class="text-3xl font-bold text-slate-800">
            Forgot Password?
        </h2>

        <p class="mt-2 text-slate-500">
            Enter your email address and we'll send you a password reset link.
        </p>

    </div>

    @if (session('status'))
        <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <x-input label="Email Address" name="email" type="email" placeholder="you@example.com" :value="old('email')"
            required autofocus />

        <x-button type="submit" size="lg" full>

            Send Reset Link

        </x-button>

    </form>

    <div class="mt-8 text-center text-sm text-slate-500">

        Remember your password?

        <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-700">

            Back to Login

        </a>

    </div>

</x-guest-layout>
