<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <title>Edit Barang</title>
</head>
<body>
    <div class="flex min-h-screen flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h1 class="mt-10 text-center text-3xl/9 font-bold tracking-tight text-gray-900">Edit Barang</h1>
        </div>
        
        @if(session('success'))
            <script>
                alert('{{ session('success') }}');
                window.history.replaceState({}, document.title, window.location.pathname);
            </script>
        @endif

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" action="{{ route('items.update', $itemInstance->instance_id) }}" method="POST">
                @csrf
                @method('PUT')
                <div>
                    <label for="specifications" class="block text-sm/6 font-medium text-gray-900">Spesifikasi</label>
                    <div class="mt-2">
                        <textarea name="specifications" id="specifications" autocomplete="specifications" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" rows="4">{{ $itemInstance->specifications }}</textarea>
                    </div>
                </div>

                <div>
                    <label for="condition_status" class="block text-sm/6 font-medium text-gray-900">Kondisi</label>
                    <div class="mt-2">
                        <select name="condition_status" id="condition_status" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                            <option value="Good" {{ $itemInstance->condition_status == 'Good' ? 'selected' : '' }}>Good</option>
                            <option value="Damaged" {{ $itemInstance->condition_status == 'Damaged' ? 'selected' : '' }}>Damaged</option>
                        </select>
                    </div>
                </div>
        
                <div class="flex justify-end">
                    <a href="{{ route('items.detail', $itemInstance->item_id) }}" class="flex w-auto justify-center rounded-md bg-gray-300 px-2 py-1 text-sm font-semibold text-gray-900 shadow-xs hover:bg-gray-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600 mr-2">Cancel</a>
                    <button type="submit" class="flex w-auto justify-center rounded-md bg-indigo-600 px-2 py-1 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Update</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>