<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <title></title>
</head>
<body>
    <div class="flex min-h-screen flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h1 class="mt-10 text-center text-3xl/9 font-bold tracking-tight text-gray-900">Tambahkan Barang</h1>
        </div>
        
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" action="#" method="POST">
            <div>
                <label for="namaBarang" class="block text-sm/6 font-medium text-gray-900">Nama Barang</label>
                <div class="mt-2">
                    <input type="text" name="namaBarang" id="namaBarang" autocomplete="namaBarang" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                </div>
            </div>
      
            <div>
                <div class="flex items-center justify-between">
                    <label for="spesifikasi" class="block text-sm/6 font-medium text-gray-900">Spesifikasi</label>
                </div>
                <div class="mt-2">
                    <textarea name="spesifikasi" id="spesifikasi" autocomplete="spesifikasi" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" rows="4"></textarea>
                </div>
            </div>
      
            <div class="flex justify-end">
              <a href="{{ url('items') }}" class="flex w-auto justify-center rounded-md bg-gray-300 px-2 py-1 text-sm font-semibold text-gray-900 shadow-xs hover:bg-gray-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600 mr-2">Cancel</a>
              <button type="submit" class="flex w-auto justify-center rounded-md bg-indigo-600 px-2 py-1 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Submit</button>
            </div>
          </form>
        </div>
    </div>
</body>
</html>