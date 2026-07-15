<section class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">

    <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-800">
            Profile Information
        </h2>

        <p class="mt-2 text-sm text-slate-500">
            Update your personal information and email address.
        </p>
    </div>

    <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('PATCH')

        {{-- Name --}}
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">
                Full Name
            </label>

            <x-input id="name" name="name" type="text" :value="old('name', $user->name)" required autofocus
                autocomplete="name" />

            @error('name')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">
                Email Address
            </label>

            <x-input id="email" name="email" type="email" :value="old('email', $user->email)" required autocomplete="username" />

            @error('email')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())

                <div class="mt-5 rounded-2xl border border-amber-200 bg-amber-50 p-4">

                    <p class="text-sm text-amber-800">
                        Your email address has not been verified.
                    </p>

                    <button form="send-verification"
                        class="mt-3 text-sm font-semibold text-blue-600 hover:text-blue-700">
                        Resend verification email
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <div class="mt-3 rounded-xl bg-green-100 px-4 py-3 text-sm font-medium text-green-700">
                            Verification email sent successfully.
                        </div>
                    @endif

                </div>

            @endif
        </div>

        {{-- Save --}}
        <div class="flex items-center gap-4">

            <x-button type="submit">
                Save Changes
            </x-button>

            @if (session('status') === 'profile-updated')
                <span x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="rounded-full bg-green-100 px-4 py-2 text-sm font-medium text-green-700">
                    ✓ Saved successfully
                </span>
            @endif

        </div>

    </form>

</section>
