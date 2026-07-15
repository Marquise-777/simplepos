<x-guest-layout>

    <div class="mb-8 text-center">

        <h2 class="text-3xl font-bold text-slate-800">
            Verify Your Email 📧
        </h2>

        <p class="mt-2 text-slate-500">
            Thanks for signing up! Please verify your email address by clicking the
            verification link we just sent. If you didn't receive it, we'll happily
            send you another.
        </p>

    </div>

    @if (session('status') === 'verification-link-sent')
        <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            A new verification link has been sent to your email address.
        </div>
    @endif

    <div class="space-y-4">

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <x-button type="submit" size="lg" full>

                Resend Verification Email

            </x-button>

        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <x-button type="submit" variant="ghost" size="lg" full>

                Log Out

            </x-button>

        </form>

    </div>

</x-guest-layout>
