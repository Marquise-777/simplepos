<section class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">

    <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-800">
            Update Password
        </h2>

        <p class="mt-2 text-sm text-slate-500">
            Choose a strong password to help keep your account secure.
        </p>
    </div>

    <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Current Password --}}
        <div>
            <label for="update_password_current_password" class="mb-2 block text-sm font-medium text-slate-700">
                Current Password
            </label>

            <x-input id="update_password_current_password" name="current_password" type="password"
                autocomplete="current-password" />

            @error('current_password', 'updatePassword')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- New Password --}}
        <div>
            <label for="update_password_password" class="mb-2 block text-sm font-medium text-slate-700">
                New Password
            </label>

            <x-input id="update_password_password" name="password" type="password" autocomplete="new-password" />

            @error('password', 'updatePassword')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div>
            <label for="update_password_password_confirmation" class="mb-2 block text-sm font-medium text-slate-700">
                Confirm Password
            </label>

            <x-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                autocomplete="new-password" />

            @error('password_confirmation', 'updatePassword')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4">

            <x-button>
                Update Password
            </x-button>

            @if (session('status') === 'password-updated')
                <span x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="rounded-full bg-green-100 px-4 py-2 text-sm font-medium text-green-700">
                    ✓ Password updated successfully
                </span>
            @endif

        </div>

    </form>

</section>
