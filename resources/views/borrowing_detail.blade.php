<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-notification />
    @php
        // Ambil data utama
        $activity = $borrowing->activity;
        $borrower = $borrowing->borrower;
        $firstDetail = $borrowingDetails->first();
        $borrowingDate = $firstDetail?->borrowing_date ?? null;
        // Ambil admin role 0 dan 1
        $adminRole0 = \App\Models\Admin::where('role', 0)->first();
        $adminRole1 = \App\Models\Admin::where('role', 1)->first();
    @endphp

    <div class="p-4 border-b border-gray-200 bg-gray-50 grid grid-cols-1 md:grid-cols-2 gap-2 text-sm mb-4">
        <div>
            <span class="font-semibold">Nama Kegiatan:</span>
            {{ $activity?->activity_name ?? '-' }}
        </div>
        <div>
            <span class="font-semibold">Tanggal Kegiatan:</span>
            {{ $activity?->activity_date ? \Carbon\Carbon::parse($activity->activity_date)->format('d-m-Y') : '-' }}
        </div>
        <div>
            <span class="font-semibold">Nama Peminjam:</span>
            {{ $borrower?->name ?? '-' }}
        </div>
        <div>
            <span class="font-semibold">Tanggal Pinjam:</span>
            {{ $borrowingDate ? \Carbon\Carbon::parse($borrowingDate)->format('d-m-Y') : '-' }}
        </div>
        <div>
            <span class="font-semibold">Penanggung Jawab DITMAWA:</span>
            {{ $adminRole0?->admin_name ?? '-' }}
        </div>
        <div>
            <span class="font-semibold">Penanggung Jawab Tim Sisfo DITMAWA</span>
            {{ $adminRole1?->admin_name ?? '-' }}
        </div>
    </div>

    <div class="parent">
        <div class="div1">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <!-- Wrapper with scroll -->
                <div class="w-full overflow-x-auto overflow-y-auto max-h-140 border rounded-md border-gray-300">
                    <table class="min-w-full table-auto border-collapse">
                        <thead class="bg-gray-50 sticky top-0 z-10">
                            <tr>
                                <th class="px-1 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">No</th>
                                <th class="px-4 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">List Barang</th>
                                <th class="min-w-[200px] px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Status</th>
                                {{-- <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Tanggal Pinjam</th> --}}
                                <th class="px-3 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Rencana Pengembalian</th>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Tanggal Kembali</th>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Bukti Peminjaman</th>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Bukti Pengembalian</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @php
                                $previousData = null; // Variabel untuk menyimpan data sebelumnya
                                $rowspanCount = 0; // Variabel untuk menghitung jumlah baris yang sama
                            @endphp

                            @foreach($borrowingDetails as $index => $detail)
                                @php
                                    // Gabungkan data yang sama
                                    $currentData = [
                                        'borrowing_id' => $detail->borrowing_id,
                                        // 'borrowing_date' => $detail->borrowing_date,
                                        'planned_return_date' => $detail->planned_return_date,
                                        'return_date' => $detail->return_date,
                                        'proof_file' => $detail->proof_file,
                                    ];

                                    // Kelompokkan berdasarkan id transaksi atau field yang sama
                                    $showProof = $previousData === null ||
                                        $detail->borrowing_id !== $previousData['borrowing_id'];
                                    $rowspanProof = $borrowingDetails->where('borrowing_id', $detail->borrowing_id)->count();
                                @endphp

                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center">{{ $loop->iteration }}</td>
                                    <td class="px-2 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center max-w-xs">
                                        <div x-data="{ expanded: false }">
                                            <span x-show="!expanded">
                                                {{ \Illuminate\Support\Str::limit($detail->instance->specifications, 30) ? $detail->instance->item_name . ' ' . \Illuminate\Support\Str::limit($detail->instance->specifications, 30) : $detail->instance->item->item_name }}
                                                @if(strlen($detail->instance->specifications) > 30)
                                                    <button @click="expanded = true" class="text-blue-600 hover:underline text-xs ml-1">See more</button>
                                                @endif
                                            </span>
                                            <span x-show="expanded">
                                                {{ $detail->instance->item->item_name }} {{ $detail->instance->specifications }}
                                                <button @click="expanded = false" class="text-blue-600 hover:underline text-xs ml-1">See less</button>
                                            </span>
                                        </div>
                                    </td>
                                    
                                    <td class="px-10 py-3 text-center text-sm text-gray-900 border-b border-r border-gray-300">
                                        <form action="{{ route('borrowings.updateStatus', $detail->detail_id) }}" method="POST">
                                            @csrf
                                            @method('POST')
                                            <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" name="status" onchange="this.form.submit()" class="status-dropdown">
                                                <option value="Not Returned" {{ $detail->return_status === 'Not Returned' ? 'selected' : '' }}>Dipinjam</option>
                                                <option value="Returned" {{ $detail->return_status === 'Returned' ? 'selected' : '' }}>Dikembalikan</option>
                                            </select>
                                        </form>
                                    </td>
                                    
                                    @if($previousData !== $currentData)
                                        @php
                                            // Hitung jumlah baris yang sama untuk data ini
                                            $rowspanCount = $borrowingDetails->filter(function ($d) use ($currentData) {
                                                return 
                                                        // $d->borrowing_date === $currentData['borrowing_date'] &&
                                                       $d->planned_return_date === $currentData['planned_return_date'] &&
                                                       $d->return_date === $currentData['return_date'] &&
                                                       $d->proof_file === $currentData['proof_file'];
                                            })->count();
                                        @endphp

                                        {{-- <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center" rowspan="{{ $rowspanCount }}">
                                            {{ \Carbon\Carbon::parse($detail->borrowing_date)->format('d-m-Y') }}
                                        </td> --}}
                                        <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center" rowspan="{{ $rowspanCount }}">
                                            {{ \Carbon\Carbon::parse($detail->planned_return_date)->format('d-m-Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center" rowspan="{{ $rowspanCount }}">
                                            {{ $detail->return_date ? \Carbon\Carbon::parse($detail->return_date)->format('d-m-Y') : 'Belum Dikembalikan' }}
                                        </td>
                                    @endif

                                    @if($showProof)
                                        <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center" rowspan="{{ $rowspanProof }}">
                                            @if($detail->borrowing->borrowing_proof)
                                                <!-- Tombol lihat gambar -->
                                                <button data-modal-target="modal-bukti-peminjaman-{{ $detail->borrowing_id }}" data-modal-toggle="modal-bukti-peminjaman-{{ $detail->borrowing_id }}" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="button">
                                                    Lihat Gambar
                                                </button>
                                                <!-- Modal lihat gambar -->
                                                <div id="modal-bukti-peminjaman-{{ $detail->borrowing_id }}" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                                    <div class="relative p-4 w-full max-w-2xl max-h-full">
                                                        <div class="relative bg-white rounded-lg shadow-sm">
                                                            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                                                                <h3 class="text-xl font-semibold text-gray-900">
                                                                    Bukti Peminjaman
                                                                </h3>
                                                                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="modal-bukti-peminjaman-{{ $detail->borrowing_id }}">
                                                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                                    </svg>
                                                                    <span class="sr-only">Close modal</span>
                                                                </button>
                                                            </div>
                                                            <div class="p-4 md:p-5 flex flex-col items-center">
                                                                <img src="{{ asset('storage/' . $detail->borrowing->borrowing_proof) }}" alt="Bukti Peminjaman" class="w-96 max-h-[60vh] object-contain rounded-md mb-4">
                                                                <button
                                                                    onclick="confirmDelete('{{ route('borrowings.deleteProof', ['id' => $detail->borrowing_id, 'type' => 'borrowing']) }}')"
                                                                    class="block text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mt-2"
                                                                    type="button">
                                                                    Hapus
                                                                </button>
                                                                {{-- Form tetap ada untuk fallback jika JS mati --}}
                                                                <form id="delete-proof-borrowing-{{ $detail->borrowing_id }}" action="{{ route('borrowings.deleteProof', ['id' => $detail->borrowing_id, 'type' => 'borrowing']) }}" method="POST" style="display: none;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <!-- Modal toggle upload -->
                                                <button data-modal-target="modal-bukti-peminjaman-{{ $detail->borrowing_id }}" data-modal-toggle="modal-bukti-peminjaman-{{ $detail->borrowing_id }}" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="button">
                                                    Upload Bukti
                                                </button>
                                                <!-- Main modal upload -->
                                                <div id="modal-bukti-peminjaman-{{ $detail->borrowing_id }}" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                                    <div class="relative p-4 w-full max-w-2xl max-h-full">
                                                        <div class="relative bg-white rounded-lg shadow-sm">
                                                            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                                                                <h3 class="text-xl font-semibold text-gray-900">
                                                                    Upload Bukti Peminjaman
                                                                </h3>
                                                                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="modal-bukti-peminjaman-{{ $detail->borrowing_id }}">
                                                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                                    </svg>
                                                                    <span class="sr-only">Close modal</span>
                                                                </button>
                                                            </div>
                                                            <div class="p-4 md:p-5 space-y-4">
                                                                <form action="{{ route('borrowings.uploadProof', ['id' => $detail->borrowing_id, 'type' => 'borrowing']) }}" method="POST" enctype="multipart/form-data" class="flex flex-col items-center">
                                                                    @csrf
                                                                    <label for="borrowing-proof-{{ $detail->borrowing_id }}" class="w-full border-2 border-dashed border-gray-300 rounded-lg p-6 flex flex-col items-center cursor-pointer hover:border-indigo-400 transition">
                                                                        <svg xml:space="preserve" viewBox="0 0 184.69 184.69" width="60px" height="60px">
                                                                            <g><g><g>
                                                                                <path d="M149.968,50.186c-8.017-14.308-23.796-22.515-40.717-19.813
                                                                                    C102.609,16.43,88.713,7.576,73.087,7.576c-22.117,0-40.112,17.994-40.112,40.115c0,0.913,0.036,1.854,0.118,2.834
                                                                                    C14.004,54.875,0,72.11,0,91.959c0,23.456,19.082,42.535,42.538,42.535h33.623v-7.025H42.538
                                                                                    c-19.583,0-35.509-15.929-35.509-35.509c0-17.526,13.084-32.621,30.442-35.105c0.931-0.132,1.768-0.633,2.326-1.392
                                                                                    c0.555-0.755,0.795-1.704,0.644-2.63c-0.297-1.904-0.447-3.582-0.447-5.139c0-18.249,14.852-33.094,33.094-33.094
                                                                                    c13.703,0,25.789,8.26,30.803,21.04c0.63,1.621,2.351,2.534,4.058,2.14c15.425-3.568,29.919,3.883,36.604,17.168
                                                                                    c0.508,1.027,1.503,1.736,2.641,1.897c17.368,2.473,30.481,17.569,30.481,35.112c0,19.58-15.937,35.509-35.52,35.509H97.391
                                                                                    v7.025h44.761c23.459,0,42.538-19.079,42.538-42.535C184.69,71.545,169.884,53.901,149.968,50.186z"
                                                                                    style="fill:#010002;"></path>
                                                                                <path d="M108.586,90.201c1.406-1.403,1.406-3.672,0-5.075L88.541,65.078
                                                                                    c-0.701-0.698-1.614-1.045-2.534-1.045l-0.064,0.011c-0.018,0-0.036-0.011-0.054-0.011c-0.931,0-1.85,0.361-2.534,1.045
                                                                                    L63.31,85.127c-1.403,1.403-1.403,3.672,0,5.075c1.403,1.406,3.672,1.406,5.075,0L82.296,76.29v97.227
                                                                                    c0,1.99,1.603,3.597,3.593,3.597c1.979,0,3.59-1.607,3.59-3.597V76.165l14.033,14.036
                                                                                    C104.91,91.608,107.183,91.608,108.586,90.201z"
                                                                                    style="fill:#010002;"></path>
                                                                            </g></g></g>
                                                                        </svg>
                                                                        <p class="mt-2 text-gray-700 text-center">Drag & drop file di sini atau klik untuk pilih file</p>
                                                                        <span class="file-name text-xs text-gray-500 mt-2"></span>
                                                                    </label>
                                                                    <input class="hidden" name="proof" id="borrowing-proof-{{ $detail->borrowing_id }}" type="file" accept="image/*" required>
                                                                    <div id="file-size-alert-borrowing-{{ $detail->borrowing_id }}" class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 mt-3" role="alert" style="display:none;">
                                                                        <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                                                        </svg>
                                                                        <span class="sr-only">Info</span>
                                                                        <div>
                                                                            <span class="font-medium">Ukuran file terlalu besar!</span> Maksimal ukuran file adalah 2MB.
                                                                        </div>
                                                                    </div>
                                                                    <button type="submit" class="mt-4 px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-500 w-full">Upload</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                    @endif

                                    <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center">
                                        @if($detail->return_proof)
                                            <!-- Tombol lihat gambar -->
                                            <button data-modal-target="modal-bukti-pengembalian-{{ $detail->detail_id }}" data-modal-toggle="modal-bukti-pengembalian-{{ $detail->detail_id }}" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="button">
                                                Lihat Gambar
                                            </button>
                                            <!-- Modal lihat gambar -->
                                            <div id="modal-bukti-pengembalian-{{ $detail->detail_id }}" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                                <div class="relative p-4 w-full max-w-2xl max-h-full">
                                                    <div class="relative bg-white rounded-lg shadow-sm">
                                                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                                                            <h3 class="text-xl font-semibold text-gray-900">
                                                                Bukti Pengembalian
                                                            </h3>
                                                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="modal-bukti-pengembalian-{{ $detail->detail_id }}">
                                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                                </svg>
                                                                <span class="sr-only">Close modal</span>
                                                            </button>
                                                        </div>
                                                        <div class="p-4 md:p-5 flex flex-col items-center">
                                                            <img src="{{ asset('storage/' . $detail->return_proof) }}" alt="Bukti Pengembalian" class="w-96 max-h-[60vh] object-contain rounded-md mb-4">
                                                            <button
                                                                onclick="confirmDelete('{{ route('borrowings.deleteProof', ['id' => $detail->detail_id, 'type' => 'return']) }}')"
                                                                class="block text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mt-2"
                                                                type="button">
                                                                Hapus
                                                            </button>
                                                            <form id="delete-proof-return-{{ $detail->detail_id }}" action="{{ route('borrowings.deleteProof', ['id' => $detail->detail_id, 'type' => 'return']) }}" method="POST" style="display: none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <!-- Modal toggle upload -->
                                            <button data-modal-target="modal-bukti-pengembalian-{{ $detail->detail_id }}" data-modal-toggle="modal-bukti-pengembalian-{{ $detail->detail_id }}" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="button">
                                                Upload Bukti
                                            </button>
                                            <!-- Main modal upload -->
                                            <div id="modal-bukti-pengembalian-{{ $detail->detail_id }}" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                                <div class="relative p-4 w-full max-w-2xl max-h-full">
                                                    <div class="relative bg-white rounded-lg shadow-sm">
                                                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                                                            <h3 class="text-xl font-semibold text-gray-900">
                                                                Upload Bukti Pengembalian
                                                            </h3>
                                                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="modal-bukti-pengembalian-{{ $detail->detail_id }}">
                                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                                </svg>
                                                                <span class="sr-only">Close modal</span>
                                                            </button>
                                                        </div>
                                                        <div class="p-4 md:p-5 space-y-4">
                                                            <form action="{{ route('borrowings.uploadProof', ['id' => $detail->detail_id, 'type' => 'return']) }}" method="POST" enctype="multipart/form-data" class="flex flex-col items-center">
                                                                @csrf
                                                                <label for="return-proof-{{ $detail->detail_id }}" class="w-full border-2 border-dashed border-gray-300 rounded-lg p-6 flex flex-col items-center cursor-pointer hover:border-indigo-400 transition">
                                                                    <svg xml:space="preserve" viewBox="0 0 184.69 184.69" width="60px" height="60px">
                                                                        <g><g><g>
                                                                            <path d="M149.968,50.186c-8.017-14.308-23.796-22.515-40.717-19.813
                                                                                C102.609,16.43,88.713,7.576,73.087,7.576c-22.117,0-40.112,17.994-40.112,40.115c0,0.913,0.036,1.854,0.118,2.834
                                                                                C14.004,54.875,0,72.11,0,91.959c0,23.456,19.082,42.535,42.538,42.535h33.623v-7.025H42.538
                                                                                c-19.583,0-35.509-15.929-35.509-35.509c0-17.526,13.084-32.621,30.442-35.105c0.931-0.132,1.768-0.633,2.326-1.392
                                                                                c0.555-0.755,0.795-1.704,0.644-2.63c-0.297-1.904-0.447-3.582-0.447-5.139c0-18.249,14.852-33.094,33.094-33.094
                                                                                c13.703,0,25.789,8.26,30.803,21.04c0.63,1.621,2.351,2.534,4.058,2.14c15.425-3.568,29.919,3.883,36.604,17.168
                                                                                c0.508,1.027,1.503,1.736,2.641,1.897c17.368,2.473,30.481,17.569,30.481,35.112c0,19.58-15.937,35.509-35.52,35.509H97.391
                                                                                v7.025h44.761c23.459,0,42.538-19.079,42.538-42.535C184.69,71.545,169.884,53.901,149.968,50.186z"
                                                                                style="fill:#010002;"></path>
                                                                            <path d="M108.586,90.201c1.406-1.403,1.406-3.672,0-5.075L88.541,65.078
                                                                                c-0.701-0.698-1.614-1.045-2.534-1.045l-0.064,0.011c-0.018,0-0.036-0.011-0.054-0.011c-0.931,0-1.85,0.361-2.534,1.045
                                                                                L63.31,85.127c-1.403,1.403-1.403,3.672,0,5.075c1.403,1.406,3.672,1.406,5.075,0L82.296,76.29v97.227
                                                                                c0,1.99,1.603,3.597,3.593,3.597c1.979,0,3.59-1.607,3.59-3.597V76.165l14.033,14.036
                                                                                C104.91,91.608,107.183,91.608,108.586,90.201z"
                                                                                style="fill:#010002;"></path>
                                                                        </g></g></g>
                                                                    </svg>
                                                                    <p class="mt-2 text-gray-700 text-center">Drag & drop file di sini atau klik untuk pilih file</p>
                                                                    <span class="file-name text-xs text-gray-500 mt-2"></span>
                                                                </label>
                                                                <input class="hidden" name="proof" id="return-proof-{{ $detail->detail_id }}" type="file" accept="image/*" required>
                                                                <div id="file-size-alert-return-{{ $detail->detail_id }}" class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 mt-3" role="alert" style="display:none;">
                                                                    <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                                                    </svg>
                                                                    <span class="sr-only">Info</span>
                                                                    <div>
                                                                        <span class="font-medium">Ukuran file terlalu besar!</span> Maksimal ukuran file adalah 2MB.
                                                                    </div>
                                                                </div>
                                                                <button type="submit" class="mt-4 px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-500 w-full">Upload</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                </tr>

                                @php
                                    $previousData = $currentData; // Perbarui data sebelumnya
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Akhir wrapper dengan scroll -->
                <div class="mt-4">
                    <a href="{{ route('borrowings.index') }}" class="text-blue-600 hover:text-blue-900">Kembali ke Daftar Peminjaman</a>
                </div>
            </div>
        </div>
    </div>
</x-layout>