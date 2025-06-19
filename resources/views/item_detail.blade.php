<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="parent">
        <x-notification />

        <div class="div1">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <!-- Tambahkan wrapper dengan scroll -->
                <div class="overflow-y-auto max-h-130 border rounded-md border-gray-300">
                    <table class="min-w-full border-collapse">
                        <thead class="bg-gray-50 sticky top-0 z-10">
                            <tr>
                                <th class="px-1 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">No</th>
                                <th class="px-1 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">ID Barang</th>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Nama Barang</th>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Spesifikasi</th>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Tanggal Ditambahkan</th>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">
                                    Status <br>
                                    <span class="text-xs text-green-700 font-semibold">
                                        Tersedia: {{ $availableCount }}
                                    </span>
                                </th>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Kondisi</th>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($itemDetails as $detail)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center">{{ $detail->id_barang }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center">{{ $detail->item_name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 max-w-xs">
                                        <div x-data="{ expanded: false }">
                                            <span x-show="!expanded">
                                                {{ \Illuminate\Support\Str::limit($detail->specifications, 60) }}
                                                @if(strlen($detail->specifications) > 60)
                                                    <button @click="expanded = true" class="text-blue-600 hover:underline text-xs ml-1">See more</button>
                                                @endif
                                            </span>
                                            <span x-show="expanded">
                                                {{ $detail->specifications }}
                                                <button @click="expanded = false" class="text-blue-600 hover:underline text-xs ml-1">See less</button>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center">{{ $detail->date_added }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center">{{ $detail->status }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center">
                                        <form action="{{ route('items.update', $detail->instance_id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" name="condition_status" onchange="this.form.submit()">
                                                <option value="Good" {{ $detail->condition_status == 'Good' ? 'selected' : '' }}>Good</option>
                                                <option value="Damaged" {{ $detail->condition_status == 'Damaged' ? 'selected' : '' }}>Damaged</option>
                                            </select>
                                        </form>
                                    </td>
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
                                                <a href="{{ route('items.edit', $detail->instance_id) }}"
                                                    class="block px-4 py-2 text-sm text-blue-700 border border-transparent rounded-md m-1 hover:bg-blue-50 hover:text-blue-900 hover:border-blue-400 transition text-center">
                                                    Edit
                                                </a>
                                                <button type="button"
                                                    class="block px-11 py-2 text-sm text-red-700 border border-transparent rounded-md m-1 hover:bg-red-50 hover:text-red-900 hover:border-red-400 transition"
                                                    onclick="confirmDelete('{{ route('items.destroy', $detail->instance_id) }}')">
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
                <!-- Akhir wrapper dengan scroll -->
                <div class="mt-3 mb-2 px-2">
                    {{ $itemDetails->links() }}
                </div>
                <div class="mt-4">
                    <a href="{{ route('items.index') }}" class="text-blue-600 hover:text-blue-900">Kembali ke Daftar Barang</a>
                </div>
            </div>
        </div>
    </div>
</x-layout>