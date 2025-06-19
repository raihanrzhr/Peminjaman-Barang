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
                <div class="overflow-y-auto max-h-130 border rounded-md border-gray-300">
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
                                                <button type="button"
                                                    class="block px-11 py-2 text-sm text-red-700 border border-transparent rounded-md m-1 hover:bg-red-50 hover:text-red-900 hover:border-red-400 transition"
                                                    onclick="confirmDelete('{{ route('items.destroyAll', $item->item_id) }}')">
                                                    Delete
                                                </button>
                                                <a href="{{ route('items.detail', $item->item_id) }}"
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
                <div class="mt-3 mb-2 px-2">
                    {{ $items->links() }}
                </div>
            </div>
        </div>
        <div class="div2">
            <button class="btn-tambah" onclick="window.location='{{ route('add_items') }}'">Tambah Barang</button>
        </div>
        <div class="div3">
            <!-- Tombol untuk membuka modal tambah kategori -->
            <button type="button"
                data-modal-target="add-category-modal"
                data-modal-toggle="add-category-modal"
                class="px-5 py-2.5 text-sm font-medium text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-center"
            >
                Tambah Kategori
            </button>

            <!-- Modal Flowbite untuk tambah kategori -->
            <div id="add-category-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <div class="relative bg-white rounded-lg shadow-sm">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 border-b rounded-t border-gray-200">
                            <h3 class="text-xl font-semibold text-gray-900">
                                Tambah Kategori
                            </h3>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="add-category-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-4">
                            <form method="POST" action="{{ route('categories.store') }}">
                                @csrf
                                <div class="mb-4">
                                    <input type="text" name="category" required placeholder="Nama kategori"
                                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-indigo-600">
                                </div>
                                <div class="flex justify-end gap-2">
                                    <button type="button"
                                        class="px-3 py-1 rounded bg-gray-300 text-gray-800 hover:bg-gray-400"
                                        data-modal-hide="add-category-modal">Cancel</button>
                                    <button type="submit"
                                        class="px-3 py-1 rounded bg-indigo-600 text-white hover:bg-indigo-700">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>