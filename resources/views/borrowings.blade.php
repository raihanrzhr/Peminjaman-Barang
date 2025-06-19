<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    
    <div class="parent">
        <x-notification />

        <div class="div1">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <!-- Tambahkan wrapper dengan scroll horizontal dan vertikal -->
                <div class="overflow-x-auto overflow-y-auto max-h-130 border border-gray-300">
                    <table class="min-w-full border-collapse">
                        <thead class="bg-gray-50 sticky top-0 z-10">
                            <tr>
                                <th class="px-3 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">No</th>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Peminjam</th>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Kegiatan</th>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Penanggung jawab</th>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($borrowings as $index => $borrowing)
                                <tr id="row-{{ $borrowing->borrowing_id }}">
                                    <td class="px-6 py-3 text-center text-sm text-gray-900 border-b border-r border-gray-300">{{ $index + 1 }}</td>
                                    <td class="px-6 py-3 text-center text-sm text-gray-900 border-b border-r border-gray-300">{{ $borrowing->borrower->name }}</td>
                                    <td class="px-6 py-3 text-center text-sm text-gray-900 border-b border-r border-gray-300">{{ $borrowing->activity->activity_name }}</td>
                                    <td class="px-6 py-3 text-center text-sm text-gray-900 border-b border-r border-gray-300">{{ $borrowing->admin->admin_name }}</td>
                                    <td class="px-1 py-4 text-sm text-center relative">
                                        <div 
                                            x-data="{ open: false, top: 0, left: 0, height: 0 }" 
                                            class="inline-block"
                                            @keydown.escape.window="open = false"
                                        >
                                            <button 
                                                @click="open = true; $nextTick(() => {
                                                    const rect = $event.target.getBoundingClientRect();
                                                    top = rect.top + window.scrollY - 8; // sedikit naik dari button
                                                    left = rect.left + window.scrollX;
                                                    height = rect.height;
                                                })"
                                                class="p-1 border border-gray-300 rounded-md hover:bg-gray-200 focus:outline-none"
                                                type="button"
                                            >
                                                <!-- Meatballs icon -->
                                                <svg class="w-5 h-5 text-gray-800" fill="currentColor" viewBox="0 0 24 24">
                                                    <circle cx="6" cy="12" r="1.5"/>
                                                    <circle cx="12" cy="12" r="1.5"/>
                                                    <circle cx="18" cy="12" r="1.5"/>
                                                </svg>
                                            </button>
                                            <div 
                                                x-show="open"
                                                @click.away="open = false"
                                                x-transition
                                                :style="'position:fixed;top:' + (top - 120) + 'px;left:' + left + 'px;width:140px;z-index:9999'"
                                                class="bg-white border border-gray-300 rounded-lg shadow-lg py-1"
                                            >
                                                <a href="{{ route('borrowings.edit', $borrowing->borrowing_id) }}"
                                                    class="block px-4 py-2 text-sm text-blue-700 border border-transparent rounded-md m-1 hover:bg-blue-50 hover:text-blue-900 hover:border-blue-400 transition text-center">
                                                    Edit
                                                </a>
                                                <button type="button"
                                                    class="block px-11 py-2 text-sm text-red-700 border border-transparent rounded-md m-1 hover:bg-red-50 hover:text-red-900 hover:border-red-400 transition"
                                                    onclick="confirmDelete('{{ route('borrowings.destroy', $borrowing->borrowing_id) }}')">
                                                    Delete
                                                </button>
                                                <a href="{{ route('borrowings.detail', $borrowing->borrowing_id) }}"
                                                    class="block px-4 py-2 text-sm text-green-700 border border-transparent rounded-md m-1 hover:bg-green-50 hover:text-green-900 hover:border-green-400 transition text-center">
                                                    Detail
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Akhir wrapper dengan scroll -->
                <div class="mt-3 mb-2 px-2">
                    {{ $borrowings->links() }}
                </div>
            </div>
        </div>
        <div class="div2">
            <button class="btn-tambah" onclick="window.location='{{ route('borrowings.create') }}'">Tambah Peminjaman</button>
        </div>
        <div class="div3">
            {{-- <div class="search">
                <input type="text" class="search__input" placeholder="Type your text">
                <button class="search__button">
                    <svg class="search__icon" aria-hidden="true" viewBox="0 0 24 24">
                        <g>
                            <path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path>
                        </g>
                    </svg>
                </button>
            </div> --}}
        </div>
    </div>
    
</x-layout>