<section class="rounded-3xl border border-red-200 bg-red-50 p-8 shadow-sm">

    <div class="flex items-start justify-between gap-6">

        <div>
            <h2 class="text-2xl font-bold text-red-700">
                Delete Account
            </h2>

            <p class="mt-3 max-w-2xl text-sm leading-6 text-red-600">
                Permanently delete your account and all associated data.
                This action cannot be undone. Make sure you have downloaded
                anything you wish to keep before continuing.
            </p>
        </div>

        <x-button variant="danger" x-data x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
            Delete Account
        </x-button>

    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>

        <form method="POST" action="{{ route('profile.destroy') }}" class="p-8">

            @csrf
            @method('DELETE')

            <div class="mb-6">

                <div class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-red-100 text-red-600">
                    🗑️
                </div>

                <h2 class="text-2xl font-bold text-slate-800">
                    Delete your account?
                </h2>

                <p class="mt-3 text-sm leading-6 text-slate-500">
                    This action is permanent. All your account information,
                    business data, invoices, reports, and settings will be
                    permanently removed and cannot be recovered.
                </p>

            </div>

            <div>

                <label for="password" class="mb-2 block text-sm font-medium text-slate-700">
                    Confirm your password
                </label>

                <x-input id="password" name="password" type="password" placeholder="Enter your password" />

                @error('password', 'userDeletion')
                    <p class="mt-2 text-sm text-red-500">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            <div class="mt-8 flex justify-end gap-3">

                <x-button variant="secondary" x-on:click="$dispatch('close')">
                    Cancel
                </x-button>

                <x-button variant="danger">
                    Delete Permanently
                </x-button>

            </div>

        </form>

    </x-modal>

</section>
