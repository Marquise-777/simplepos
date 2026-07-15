<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-slate-800 leading-tight">
            Profile
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

                {{-- Profile Information --}}
                <div>
                    @include('profile.partials.update-profile-information-form')
                </div>

                {{-- Update Password --}}
                <div>
                    @include('profile.partials.update-password-form')
                </div>

                {{-- Delete Account --}}
                <div class="lg:col-span-2">
                    @include('profile.partials.delete-user-form')
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
