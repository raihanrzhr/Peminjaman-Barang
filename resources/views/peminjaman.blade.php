<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    
    <div class="parent">
        <div class="div1">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">No</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">ID Barang</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Nama Barang</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">ID Peminjam</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Nama Peminjam</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Tanggal Pinjam</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Tanggal Kembali</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-900">1</td>
                            <td class="px-6 py-4 text-sm text-gray-900">BRG001</td>
                            <td class="px-6 py-4 text-sm text-gray-900">Laptop</td>
                            <td class="px-6 py-4 text-sm text-gray-900">PMJ001</td>
                            <td class="px-6 py-4 text-sm text-gray-900">John Doe</td>
                            <td class="px-6 py-4 text-sm text-gray-900">2024-03-20</td>
                            <td class="px-6 py-4 text-sm text-gray-900">2024-03-27</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    Dipinjam
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <button class="text-blue-600 hover:text-blue-900">Edit</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="div2">
            <button class="btn-tambah">Tambah Peminjaman</button>
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