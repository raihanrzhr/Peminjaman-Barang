<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <title>Tambah Peminjaman</title>
</head>
<body>
    <div class="flex min-h-screen flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h1 class="mt-10 text-center text-3xl/9 font-bold tracking-tight text-gray-900">Tambahkan Peminjaman</h1>
        </div>
        
        @if(session('success'))
            <script>
                alert('{{ session('success') }}');
                window.history.replaceState({}, document.title, window.location.pathname);
            </script>
        @endif

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" action="{{ route('borrowings.store') }}" method="POST">
                @csrf

                <div>
                    <label for="activity_name" class="block text-sm/6 font-medium text-gray-900">Nama Kegiatan</label>
                    <div class="mt-2">
                        <input type="text" name="activity_name" id="activity_name" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" placeholder="Masukkan Nama Aktivitas">
                    </div>
                </div>
                
                <div>
                    <label for="activity_date" class="block text-sm/6 font-medium text-gray-900">Tanggal Kegiatan</label>
                    <div class="mt-2">
                        <input type="date" name="activity_date" id="activity_date" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    </div>
                </div>

                <div>
                    <label for="borrower_name" class="block text-sm/6 font-medium text-gray-900">Nama Peminjam</label>
                    <div class="mt-2">
                        <input type="text" name="borrower_name" id="borrower_name" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" placeholder="Masukkan Nama Peminjam">
                    </div>
                </div>

                <div>
                    <label for="borrower_identifier" class="block text-sm/6 font-medium text-gray-900">NIP/NOPEG/NIM</label>
                    <div class="mt-2">
                        <input type="text" name="borrower_identifier" id="borrower_identifier" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" placeholder="Masukkan NIP/NOPEG/NIM">
                    </div>
                </div>
        
                <div>
                    <label for="admin_id" class="block text-sm/6 font-medium text-gray-900">Penanggung Jawab</label>
                    <div class="mt-2">
                        <select name="admin_id" id="admin_id" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                            <option value="">-- Pilih Penanggung jawab --</option>
                            @foreach($admins as $admin)
                                <option value="{{ $admin->admin_id }}">{{ $admin->admin_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
        
                <div>
                    <label for="item_instances" class="block text-sm/6 font-medium text-gray-900">Pilih Item</label>
                    <div class="mt-2 max-h-64 overflow-y-scroll border border-gray-300 rounded-md p-2">
                        @foreach($itemInstances as $instance)
                            <div class="flex items-center">
                                <input type="checkbox" name="item_instances[]" id="item_instance_{{ $instance->instance_id }}" value="{{ $instance->instance_id }}" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <label for="item_instance_{{ $instance->instance_id }}" class="ml-2 text-sm text-gray-900">
                                    {{ $instance->item->item_name }} {{ $instance->specifications }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
        
                <div>
                    <label for="borrowing_date" class="block text-sm/6 font-medium text-gray-900">Tanggal Pinjam</label>
                    <div class="mt-2">
                        <input type="date" name="borrowing_date" id="borrowing_date" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" value="{{ date('Y-m-d') }}">
                    </div>
                </div>
                
                <div>
                    <label for="planned_return_date" class="block text-sm/6 font-medium text-gray-900">Rencana Tanggal Kembali</label>
                    <div class="mt-2">
                        <input type="date" name="planned_return_date" id="planned_return_date" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    </div>
                </div>
        
                <div class="flex justify-end">
                    <a href="{{ url('') }}" class="flex w-auto justify-center rounded-md bg-gray-300 px-2 py-1 text-sm font-semibold text-gray-900 shadow-xs hover:bg-gray-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600 mr-2">Cancel</a>
                    <button type="submit" class="flex w-auto justify-center rounded-md bg-indigo-600 px-2 py-1 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Submit</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>