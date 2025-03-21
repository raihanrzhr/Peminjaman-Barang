<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="parent">
        @if (session('success'))
            <script>
                alert('{{ session('success') }}');
            </script>
        @endif

        <div class="div1">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full border border-gray-300">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">No</th>
                            <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">ID</th>
                            <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Nama Barang</th>
                            <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Spesifikasi</th>
                            <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($items as $index => $item)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center">{{ $item->id }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center">{{ $item->nama_barang }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300">{{ $item->spesifikasi }}</td>
                                <td class="px-6 py-4 text-sm text-center">
                                    <a href="{{ route('items.edit', $item->id) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                    <form action="{{ route('items.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="div2">
            <button class="btn-tambah" onclick="window.location='{{ route('add_items') }}'">Add Item</button>
        </div>
        <div class="div3">

        </div>
    </div>
</x-layout>