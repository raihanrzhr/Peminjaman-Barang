<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    
    <div class="parent">
        <div class="div1">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">No</th>
                            <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">ID Barang</th>
                            <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Nama Barang</th>
                            <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">ID Peminjam</th>
                            <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Nama Peminjam</th>
                            <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Tanggal Pinjam</th>
                            <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Tanggal Kembali</th>
                            <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Status</th>
                            <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($borrowings as $index => $borrowing)
                            {{-- @dd($borrowing->tanggal_kembali); --}}
                            <tr id="row-{{ $borrowing->id }}">
                                <td class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">{{ $index + 1 }}</td>
                                <td class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">{{ $borrowing->id_barang }}</td>
                                <td class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">{{ $borrowing->nama_barang }}</td> 
                                <td class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">{{ $borrowing->id_peminjam }}</td>
                                <td class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">{{ $borrowing->nama_peminjam }}</td>
                                <td class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">{{ $borrowing->tanggal_pinjam }}</td>
                                <td class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300 tanggal-kembali">
                                    {{ $borrowing->tanggal_kembali ? \Carbon\Carbon::parse($borrowing->tanggal_kembali)->format('d-m-Y') : '' }}
                                </td>                                                                                              
                                <td class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">
                                    <select onchange="updateStatus('{{ $borrowing->id }}', this.value)" class="status-dropdown">
                                        <option value="Dipinjam" {{ $borrowing->tanggal_kembali === null ? 'selected' : '' }}>Dipinjam</option>
                                        <option value="Dikembalikan" {{ $borrowing->tanggal_kembali !== null ? 'selected' : '' }}>Dikembalikan</option>
                                    </select>
                                </td>
                                <td class="px-6 py-4 text-sm text-center">
                                    <a href="{{--{{ route('items.edit', $item['id']) }} --}}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                    <a href="{{--{{ route('items.delete', $item['id']) }} --}}" class="text-red-500">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="div2">
            <button class="btn-tambah" onclick="window.location='{{ route('add_borrowings') }}'">Add Borrowing</button>
        </div>
        <div class="div3">
            <div class="search">
                <input type="text" class="search__input" placeholder="Type your text">
                <button class="search__button">
                    <svg class="search__icon" aria-hidden="true" viewBox="0 0 24 24">
                        <g>
                            <path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path>
                        </g>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
</x-layout>