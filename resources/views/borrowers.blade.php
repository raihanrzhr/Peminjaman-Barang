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
                            <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Nama</th>
                            <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Keterangan</th>
                            <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($names as $index => $name)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center">{{ $name->id }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center">{{ $name->nama }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center">{{ $name->keterangan }}</td>
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
            <button class="btn-tambah-borrowers" onclick="window.location='{{ route('add_borrowers') }}'">Add Borrower</button>
        </div>
        <div class="div3">
            
        </div>
    </div>
</x-layout>