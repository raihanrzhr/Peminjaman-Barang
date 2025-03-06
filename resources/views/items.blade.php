<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="parent">
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
                                <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300">{{ $item['id'] }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300">{{ $item['namaBarang'] }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300">{{ $item['spesifikasi'] }}</td>
                                <td class="px-6 py-4 text-sm">
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
            <button class="btn-tambah" onclick="window.location='{{ route('add_items') }}'">Add Item</button>
        </div>
        <div class="div3">

        </div>
    </div>
</x-layout>