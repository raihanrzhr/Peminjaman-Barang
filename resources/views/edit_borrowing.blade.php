<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <title>Edit Peminjaman</title>
</head>
<body>
    <div class="flex min-h-screen flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h1 class="mt-10 text-center text-3xl/9 font-bold tracking-tight text-gray-900">Edit Peminjaman</h1>
        </div>
        
        {{-- @if (session('success'))
            <script>
                alert('{{ session('success') }}');
            </script>
        @endif --}}

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm px-8 py-8">
                <form class="space-y-6" action="{{ route('borrowings.update', $borrowing->borrowing_id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="activity_name" class="block text-sm/6 font-medium text-gray-900">Nama Kegiatan</label>
                        <div class="mt-2">
                            <input type="text" name="activity_name" id="activity_name" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" placeholder="Masukkan Nama Aktivitas" value="{{ $borrowing->activity->activity_name }}">
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm/6 font-medium text-gray-900">Deskripsi Kegiatan</label>
                        <div class="mt-2">
                            <textarea name="description" id="description" rows="3" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" placeholder="Masukkan Deskripsi Kegiatan">{{ $borrowing->activity->description }}</textarea>
                        </div>
                    </div>
                    
                    <div>
                        <label for="activity_date" class="block text-sm/6 font-medium text-gray-900">Tanggal Kegiatan</label>
                        <div class="mt-2">
                            <input type="date" name="activity_date" id="activity_date" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" value="{{ $borrowing->activity->activity_date }}">
                        </div>
                    </div>

                    <div>
                        <label for="borrower_name" class="block text-sm/6 font-medium text-gray-900">Nama Peminjam</label>
                        <div class="mt-2">
                            <input type="text" name="borrower_name" id="borrower_name" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" placeholder="Masukkan Nama Peminjam" value="{{ $borrowing->borrower->name }}">
                        </div>
                    </div>

                    <div>
                        <label for="borrower_identifier" class="block text-sm/6 font-medium text-gray-900">NIP/NOPEG/NIM</label>
                        <div class="mt-2">
                            <input type="text" name="borrower_identifier" id="borrower_identifier" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" placeholder="Masukkan NIP/NOPEG/NIM" value="{{ $borrowing->borrower->nip_nopeg_nim }}">
                        </div>
                    </div>
                    
                    <div>
                        <label for="admin_id_all" class="block text-sm/6 font-medium text-gray-900">Penanggung Jawab DITMAWA</label>
                        <div class="mt-2">
                            <select name="admin_id_all" id="admin_id_all" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                <option value="">-- Pilih Penanggung Jawab --</option>
                                @foreach($allAdmins as $admin)
                                    <option value="{{ $admin->admin_id }}" {{ $borrowing->admin_id == $admin->admin_id ? 'selected' : '' }}>{{ $admin->admin_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="admin_id" class="block text-sm/6 font-medium text-gray-900">Penanggung Jawab Tim Sisfo DITMAWA</label>
                        <div class="mt-2">
                            <select name="admin_id" id="admin_id" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                <option value="">-- Pilih Penanggung jawab --</option>
                                @foreach($admins as $admin)
                                    <option value="{{ $admin->admin_id }}" {{ $borrowing->admin_id == $admin->admin_id ? 'selected' : '' }}>{{ $admin->admin_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div>
                        <label for="item_instances" class="block text-sm/6 font-medium text-gray-900">Pilih Item</label>
                        <div class="mt-2">
                            <div class="border border-gray-300 rounded-md p-3">
                                <!-- Input Pencarian -->
                                <input type="text" id="search_item" placeholder="Cari item..." class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 mb-3" onkeyup="filterItems()">

                                <!-- Daftar Item -->
                                <div id="item_list" class="max-h-64 overflow-y-scroll">
                                    @foreach($itemInstances as $instance)
                                        <div class="flex items-center item-row">
                                            <input type="checkbox" name="item_instances[]" id="item_instance_{{ $instance->instance_id }}" value="{{ $instance->instance_id }}" 
                                                {{ in_array($instance->instance_id, $borrowing->itemInstances->pluck('instance_id')->toArray()) ? 'checked' : '' }}
                                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                            <label for="item_instance_{{ $instance->instance_id }}" class="ml-2 text-sm text-gray-900">
                                                {{ $instance->item->item_name }}
                                                @if($instance->specifications)
                                                    - {{ \Illuminate\Support\Str::limit($instance->specifications, 26, '...') }}
                                                @endif
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
            
                    <div>
                        <label for="borrowing_date" class="block text-sm font-medium text-gray-900">Tanggal Pinjam</label>
                        <div class="mt-2">
                            <input type="date" name="borrowing_date" id="borrowing_date" required
                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-indigo-600 sm:text-sm"
                                value="{{ $borrowing->borrowingDetails->first()->borrowing_date ?? '' }}">
                        </div>
                    </div>
                    
                    <div>
                        <label for="planned_return_date" class="block text-sm font-medium text-gray-900">Rencana Tanggal Kembali</label>
                        <div class="mt-2">
                            <input type="date" name="planned_return_date" id="planned_return_date" required
                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-indigo-600 sm:text-sm"
                                value="{{ $borrowing->borrowingDetails->first()->planned_return_date ?? '' }}">
                        </div>
                    </div>
            
                    <div class="flex justify-end">
                        <a href="{{ url('/borrowings') }}" class="flex w-auto justify-center rounded-md bg-gray-300 px-2 py-1 text-sm font-semibold text-gray-900 shadow-xs hover:bg-gray-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600 mr-2">Cancel</a>
                        <button type="submit" class="flex w-auto justify-center rounded-md bg-indigo-600 px-2 py-1 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>