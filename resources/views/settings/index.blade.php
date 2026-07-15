<x-app-layout>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Settings</h1>
                <p class="text-sm text-slate-500">Settings</p>
            </div>

            <a href="{{ route('sales.create') }}"
                class="rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-medium text-white"></a>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">settings list will appear here.</p>
        </div>
    </div>
</x-app-layout>
