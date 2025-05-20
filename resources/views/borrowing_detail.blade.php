<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-notification />
    <div class="parent">
        <div class="div1">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <!-- Wrapper with scroll -->
                <div class="overflow-y-auto max-h-96 border rounded-md border-gray-300">
                    <table class="min-w-full border-collapse">
                        <thead class="bg-gray-50 sticky top-0 z-10">
                            <tr>
                                <th class="px-1 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">No</th>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">List Barang</th>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Status</th>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Tanggal Pinjam</th>
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
                                        'borrowing_date' => $detail->borrowing_date,
                                        'planned_return_date' => $detail->planned_return_date,
                                        'return_date' => $detail->return_date,
                                        'proof_file' => $detail->proof_file,
                                    ];
                                @endphp

                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center">
                                        {{ $detail->instance->item->item_name }} {{ $detail->instance->specifications }}
                                    </td>
                                    
                                    <td class="px-6 py-3 text-center text-sm text-gray-900 border-b border-r border-gray-300">
                                        <form action="{{ route('borrowings.updateStatus', $detail->detail_id) }}" method="POST">
                                            @csrf
                                            @method('POST')
                                            <select name="status" onchange="this.form.submit()" class="status-dropdown">
                                                <option value="Not Returned" {{ $detail->return_status === 'Not Returned' ? 'selected' : '' }}>Dipinjam</option>
                                                <option value="Returned" {{ $detail->return_status === 'Returned' ? 'selected' : '' }}>Dikembalikan</option>
                                            </select>
                                        </form>
                                    </td>
                                    
                                    @if($previousData !== $currentData)
                                        @php
                                            // Hitung jumlah baris yang sama untuk data ini
                                            $rowspanCount = $borrowingDetails->filter(function ($d) use ($currentData) {
                                                return $d->borrowing_date === $currentData['borrowing_date'] &&
                                                       $d->planned_return_date === $currentData['planned_return_date'] &&
                                                       $d->return_date === $currentData['return_date'] &&
                                                       $d->proof_file === $currentData['proof_file'];
                                            })->count();
                                        @endphp

                                        <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center" rowspan="{{ $rowspanCount }}">
                                            {{ \Carbon\Carbon::parse($detail->borrowing_date)->format('d-m-Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center" rowspan="{{ $rowspanCount }}">
                                            {{ \Carbon\Carbon::parse($detail->planned_return_date)->format('d-m-Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center" rowspan="{{ $rowspanCount }}">
                                            {{ $detail->return_date ? \Carbon\Carbon::parse($detail->return_date)->format('d-m-Y') : 'Belum Dikembalikan' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center" rowspan="{{ $rowspanCount }}">
                                            @if($detail->borrowing->borrowing_proof)
                                                <img src="{{ asset('storage/' . $detail->borrowing->borrowing_proof) }}" alt="Bukti Peminjaman" class="w-32 h-32 object-cover rounded-md mx-auto">
                                            @else
                                                <form action="{{ route('borrowings.uploadProof', ['id' => $detail->borrowing_id, 'type' => 'borrowing']) }}" method="POST" enctype="multipart/form-data" class="auto-upload-form">
                                                    @csrf
                                                    <label for="borrowing-proof-{{ $detail->borrowing_id }}" class="labelFile">
                                                        <span>
                                                            <!-- SVG ICON -->
                                                            <svg xml:space="preserve" viewBox="0 0 184.69 184.69" width="60px" height="60px">
                                                                <g>
                                                                    <g>
                                                                        <g>
                                                                            <path d="M149.968,50.186c-8.017-14.308-23.796-22.515-40.717-19.813
                                                                                C102.609,16.43,88.713,7.576,73.087,7.576c-22.117,0-40.112,17.994-40.112,40.115c0,0.913,0.036,1.854,0.118,2.834
                                                                                C14.004,54.875,0,72.11,0,91.959c0,23.456,19.082,42.535,42.538,42.535h33.623v-7.025H42.538
                                                                                c-19.583,0-35.509-15.929-35.509-35.509c0-17.526,13.084-32.621,30.442-35.105c0.931-0.132,1.768-0.633,2.326-1.392
                                                                                c0.555-0.755,0.795-1.704,0.644-2.63c-0.297-1.904-0.447-3.582-0.447-5.139c0-18.249,14.852-33.094,33.094-33.094
                                                                                c13.703,0,25.789,8.26,30.803,21.04c0.63,1.621,2.351,2.534,4.058,2.14c15.425-3.568,29.919,3.883,36.604,17.168
                                                                                c0.508,1.027,1.503,1.736,2.641,1.897c17.368,2.473,30.481,17.569,30.481,35.112c0,19.58-15.937,35.509-35.52,35.509H97.391
                                                                                v7.025h44.761c23.459,0,42.538-19.079,42.538-42.535C184.69,71.545,169.884,53.901,149.968,50.186z"
                                                                                style="fill:#010002;"></path>
                                                                        </g>
                                                                        <g>
                                                                            <path d="M108.586,90.201c1.406-1.403,1.406-3.672,0-5.075L88.541,65.078
                                                                                c-0.701-0.698-1.614-1.045-2.534-1.045l-0.064,0.011c-0.018,0-0.036-0.011-0.054-0.011c-0.931,0-1.85,0.361-2.534,1.045
                                                                                L63.31,85.127c-1.403,1.403-1.403,3.672,0,5.075c1.403,1.406,3.672,1.406,5.075,0L82.296,76.29v97.227
                                                                                c0,1.99,1.603,3.597,3.593,3.597c1.979,0,3.59-1.607,3.59-3.597V76.165l14.033,14.036
                                                                                C104.91,91.608,107.183,91.608,108.586,90.201z"
                                                                                style="fill:#010002;"></path>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                            </svg>
                                                        </span>
                                                        <p>drag and drop your file here or click to select a file!</p>
                                                        <span class="file-name" style="font-size:13px;color:#555;margin-top:5px;"></span>
                                                    </label>
                                                    <input class="input" name="proof" id="borrowing-proof-{{ $detail->borrowing_id }}" type="file" accept="image/*" required>
                                                </form>
                                            @endif
                                        </td>
                                    @endif
                                        <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center">
                                            @if($detail->return_proof)
                                                <img src="{{ asset('storage/' . $detail->return_proof) }}" alt="Bukti Pengembalian" class="w-32 h-32 object-cover rounded-md mx-auto">
                                            @else
                                                <form action="{{ route('borrowings.uploadProof', ['id' => $detail->detail_id, 'type' => 'return']) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="file" name="proof" accept="image/*" required class="block w-full text-sm text-gray-900 border border-gray-300 rounded-md">
                                                    <button type="submit" class="mt-2 px-3 py-1 bg-indigo-600 text-white rounded-md hover:bg-indigo-500">Upload Bukti</button>
                                                </form>
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