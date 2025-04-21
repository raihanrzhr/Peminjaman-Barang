<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="parent">
        
        <div class="div1">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <!-- Wrapper with scroll -->
                <div class="overflow-y-auto max-h-96 border rounded-md border-gray-300">
                    <table class="min-w-full border-collapse">
                        <thead class="bg-gray-50 sticky top-0 z-10">
                            <tr>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">No</th>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">List Barang</th>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Tanggal Pinjam</th>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Rencana Pengembalian</th>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Tanggal Kembali</th>
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
                                            @if($detail->proof_file)
                                                <a href="{{ asset('storage/' . $detail->proof_file) }}" target="_blank" class="text-blue-600 hover:text-blue-900">Lihat Bukti</a>
                                            @else
                                                Tidak Ada Bukti
                                            @endif
                                        </td>
                                    @endif
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