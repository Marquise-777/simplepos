@if (session('success'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-cloak
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-8"
        x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 translate-x-8"
        class="fixed top-5 right-5 z-[9999] w-full max-w-sm">

        <div class="flex items-start gap-3 rounded-2xl border border-green-200 bg-white p-4 shadow-xl">

            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-green-100">
                <i data-lucide="circle-check-big" class="h-5 w-5 text-green-600"></i>
            </div>

            <div class="flex-1">
                <h3 class="font-semibold text-slate-900">
                    Success
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    {{ session('success') }}
                </p>
            </div>

            <button @click="show = false" class="text-slate-400 hover:text-slate-600">
                <i data-lucide="x" class="h-4 w-4"></i>
            </button>

        </div>

    </div>
@endif
