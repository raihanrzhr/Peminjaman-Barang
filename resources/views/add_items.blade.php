<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/ITB_white.png') }}" type="image/png">
    <title>Tambah Barang</title>
</head>
<body>
    <div class="flex min-h-screen flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h1 class="mt-10 text-center text-3xl/9 font-bold tracking-tight text-gray-900">Tambahkan Barang</h1>
        </div>

        {{-- {{-- @if (session('success'))
            <script>
                alert('{{ session('success') }}');
            </script>
        @endif --}}

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm px-8 py-8">
                <form class="space-y-6" action="{{ route('items.store') }}" method="POST">
                    @csrf

                    <div>
                        <label for="category" class="block text-sm/6 font-medium text-gray-900">Kategori</label>
                        <div class="mt-2">
                            <select name="category" id="category" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                <option value="" disabled selected>Pilih kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->category }}">{{ $category->category }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="item_name" class="block text-sm/6 font-medium text-gray-900">Nama Barang</label>
                        <div class="mt-2">
                            <input type="text" name="item_name" id="item_name" autocomplete="item_name" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                        </div>
                    </div>

                    <div>
                        <label for="specifications" class="block text-sm/6 font-medium text-gray-900">Spesifikasi</label>
                        <div class="mt-2">
                            <textarea name="specifications" id="specifications" autocomplete="specifications" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" rows="4"></textarea>
                        </div>
                    </div>

                    <div>
                        <label for="quantity" class="block text-sm/6 font-medium text-gray-900">Jumlah</label>
                        <div class="mt-2">
                            <input type="number" name="quantity" id="quantity" autocomplete="quantity" required min="1" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ url('items') }}" class="flex w-auto justify-center rounded-md bg-gray-300 px-2 py-1 text-sm font-semibold text-gray-900 shadow-xs hover:bg-gray-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600 mr-2">Cancel</a>
                        <button type="submit" class="flex w-auto justify-center rounded-md bg-indigo-600 px-2 py-1 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/script.js') }}?v={{ time() }}"></script>
</body>
</html>