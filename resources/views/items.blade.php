<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-notification />

    <div class="parent">
        {{-- @if (session('success'))
            <script>
                alert('{{ session('success') }}');
            </script>
        @endif --}}
        
        <div class="div1">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="overflow-y-auto max-h-96 border rounded-md border-gray-300">
                    <table class="min-w-full border border-gray-300">
                        <thead class="bg-gray-50 sticky top-0 z-10">
                            <tr> 
                                <th class="px-1 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">No</th>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Kategori</th>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Jumlah</th>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($items as $index => $item)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center">{{ $item->category }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center">{{ $item->item_instances_count }}</td>
                                    <td class="px-1 py-4 text-sm text-center relative">
                                        <div x-data="{ open: false }" class="inline-block">
                                            <button @click="open = !open" class="p-1 border border-gray-300 rounded-md hover:bg-gray-200 focus:outline-none">
                                                <!-- Meatballs icon (horizontal dots) -->
                                                <svg class="w-5 h-5 text-gray-800" fill="currentColor" viewBox="0 0 24 24">
                                                    <circle cx="6" cy="12" r="1.5"/>
                                                    <circle cx="12" cy="12" r="1.5"/>
                                                    <circle cx="18" cy="12" r="1.5"/>
                                                </svg>
                                            </button>
                                            <div x-show="open" @click.away="open = false"
                                                 class="absolute right-0 z-20 mt-2 w-36 bg-white border border-gray-300 rounded-lg shadow-lg py-1 transition">
                                                <button type="button"
                                                    class="block px-11.5 py-2 text-sm text-red-700 border border-transparent rounded-md m-1 hover:bg-red-50 hover:text-red-900 hover:border-red-400 transition"
                                                    onclick="confirmDelete('{{ route('items.destroyAll', $item->item_id) }}')">
                                                    Delete
                                                </button>
                                                <a href="{{ route('items.detail', $item->item_id) }}"
                                                   class="block px-4 py-2 text-sm text-green-700 border border-transparent rounded-md m-1 hover:bg-green-50 hover:text-green-900 hover:border-green-400 transition">
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
            </div>
        </div>
        <div class="div2">
            <button class="btn-tambah" onclick="window.location='{{ route('add_items') }}'">Tambah Barang</button>
        </div>
        <div class="div3">

        </div>
    </div>
</x-layout>