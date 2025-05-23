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
    <title>Tambah Peminjaman</title>
</head>
<body>
    <div class="flex min-h-screen flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h1 class="mt-10 text-center text-3xl/9 font-bold tracking-tight text-gray-900">Tambahkan Peminjaman</h1>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm px-8 py-8">
                <form class="space-y-6" action="{{ route('borrowings.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div>
                        <label for="activity_name" class="block text-sm/6 font-medium text-gray-900">Nama Kegiatan</label>
                        <div class="mt-2">
                            <input type="text" name="activity_name" id="activity_name" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" placeholder="Masukkan Nama Aktivitas">
                        </div>
                    </div>
                    
                    <div>
                        <label for="description" class="block text-sm/6 font-medium text-gray-900">Deskripsi Kegiatan</label>
                        <div class="mt-2">
                            <textarea name="description" id="description" rows="3" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" placeholder="Masukkan Deskripsi Kegiatan"></textarea>
                        </div>
                    </div>
                    
                    <div>
                        <label for="activity_date" class="block text-sm/6 font-medium text-gray-900">Tanggal Kegiatan</label>
                        <div class="mt-2">
                            <input type="date" name="activity_date" id="activity_date" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                        </div>
                    </div>
                    
                    <div>
                        <label for="borrower_status" class="block text-sm/6 font-medium text-gray-900">Status Peminjam</label>
                        <div class="mt-2">
                            <select name="borrower_status" id="borrower_status" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" onchange="toggleBorrowerFields()">
                                <option value="">-- Pilih Status Peminjam --</option>
                                <option value="Mahasiswa">Mahasiswa</option>
                                <option value="Pegawai Ditmawa">Pegawai Ditmawa</option>
                            </select>
                        </div>
                    </div>

                    <div id="borrower_fields">
                        <div>
                            <label for="borrower_name" class="block text-sm/6 font-medium text-gray-900">Nama Peminjam</label>
                            <div class="mt-2">
                                <input type="text" name="borrower_name" id="borrower_name" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" placeholder="Masukkan Nama Peminjam">
                            </div>
                        </div>

                        <div>
                            <label for="borrower_identifier" class="mt-6 block text-sm/6 font-medium text-gray-900">NIP/NOPEG/NIM</label>
                            <div class="mt-2">
                                <input type="text" name="borrower_identifier" id="borrower_identifier" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" placeholder="Masukkan NIP/NOPEG/NIM">
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <label for="admin_id_all" class="block text-sm/6 font-medium text-gray-900">Penanggung Jawab DITMAWA</label>
                        <div class="mt-2">
                            <select name="admin_id_all" id="admin_id_all" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                <option value="">-- Pilih Penanggung Jawab --</option>
                                @foreach($allAdmins as $admin)
                                    <option value="{{ $admin->admin_id }}">{{ $admin->admin_name }}</option>
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
                                    <option value="{{ $admin->admin_id }}">{{ $admin->admin_name }}</option>
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
                                            <input type="checkbox" name="item_instances[]" id="item_instance_{{ $instance->instance_id }}" value="{{ $instance->instance_id }}" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
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

                    <div class="max-w-lg mx-auto">
                        <label class="block mb-2 text-sm/6 font-medium text-gray-900" for="borrowing_proof">Bukti Peminjaman</label>
                        <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 " aria-describedby="borrowing_proof_help" id="borrowing_proof" name="borrowing_proof" type="file" accept="image/*">
                        <div class="mt-1 text-sm text-gray-500" id="borrowing_proof_help">Max 2MB | Unggah gambar (format: JPG, PNG, dll).</div>
                        <div id="file-size-alert" class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 mt-1" role="alert" style="display:none;">
                          <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                          </svg>
                          <span class="sr-only">Info</span>
                          <div>
                            <span class="font-medium">Ukuran file terlalu besar!</span> Maksimal ukuran file adalah 2MB.
                          </div>
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

    <script src="{{ asset('js/script.js') }}?v={{ time() }}"></script>
</body>
</html>