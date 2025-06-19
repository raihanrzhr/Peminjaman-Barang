<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="parent">
        <x-notification />
        
        <div class="div1">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="overflow-y-auto max-h-130 border rounded-md border-gray-300">
                    <table class="min-w-full border border-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">No</th>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Nama</th>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">NIP/NIM/NOPEG</th>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Keterangan</th>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($names as $index => $name)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center">{{ $name->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center">{{ $name->nip_nopeg_nim }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center">{{ $name->description }}</td>
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
                                                :style="'position:fixed;top:' + (top - 100) + 'px;left:' + left + 'px;width:140px;z-index:9999'"
                                                class="bg-white border border-gray-300 rounded-lg shadow-lg py-1"
                                            >
                                                <a href="{{ route('borrowers.edit', $name->borrower_id) }}"
                                                    class="block px-4 py-2 text-sm text-blue-700 border border-transparent rounded-md m-1 hover:bg-blue-50 hover:text-blue-900 hover:border-blue-400 transition text-center">
                                                    Edit
                                                </a>
                                                <button type="button"
                                                    class="block px-11 py-2 text-sm text-red-700 border border-transparent rounded-md m-1 hover:bg-red-50 hover:text-red-900 hover:border-red-400 transition"
                                                    onclick="confirmDelete('{{ route('borrowers.destroy', $name->borrower_id) }}')">
                                                    Delete
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 mb-2 px-2">
                    {{ $names->links() }}
                </div>
            </div>
        </div>
        <div class="div2">
            <button class="btn-tambah-borrowers" onclick="window.location='{{ route('add_borrowers') }}'">Tambah Peminjam</button>
        </div>
        <div class="div3">
            
        </div>
    </div>
</x-layout>