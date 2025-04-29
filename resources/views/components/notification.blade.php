@if (session('success'))
    <div 
        x-data="{ show: true }" 
        x-init="setTimeout(() => show = false, 2000)" 
        x-show="show"
        x-transition
        class="fixed inset-0 z-50 flex items-start justify-center"
    >
        <div class="mt-6 rounded-lg bg-green-100 p-4 text-green-700 border border-green-400 shadow-lg">
            {{ session('success') }}
        </div>
    </div>
@endif

@if (session('error'))
    <div 
        x-data="{ show: true }" 
        x-init="setTimeout(() => show = false, 2000)" 
        x-show="show"
        x-transition
        class="fixed inset-0 z-50 flex items-start justify-center"
    >
        <div class="mt-6 rounded-lg bg-red-100 p-4 text-red-700 border border-red-400 shadow-lg">
            {{ session('error') }}
        </div>
    </div>
@endif
