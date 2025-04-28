<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="parent">
        @if(session('success'))
            <script>
                alert('{{ session('success') }}');
                window.history.replaceState({}, document.title, window.location.pathname);
            </script>
        @endif

        <div class="div1">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <!-- Tambahkan wrapper dengan scroll -->
                <div class="overflow-y-auto max-h-96 border rounded-md border-gray-300">
                    <table class="min-w-full border-collapse">
                        <thead class="bg-gray-50 sticky top-0 z-10">
                            <tr>
                                <th class="px-1 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">No</th>
                                <th class="px-1 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">ID</th>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Nama Barang</th>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Spesifikasi</th>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Tanggal Ditambahkan</th>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Status</th>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Kondisi</th>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($itemDetails as $detail)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center">{{ $detail->instance_id }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center">{{ $detail->item_name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300">{{ $detail->specifications }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center">{{ $detail->date_added }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center">{{ $detail->status }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center">
                                        <form action="{{ route('items.update', $detail->instance_id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <select name="condition_status" onchange="this.form.submit()">
                                                <option value="Good" {{ $detail->condition_status == 'Good' ? 'selected' : '' }}>Good</option>
                                                <option value="Damaged" {{ $detail->condition_status == 'Damaged' ? 'selected' : '' }}>Damaged</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-center">
                                        <a href="{{ route('items.edit', $detail->instance_id) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                        <form action="{{ route('items.destroy', $detail->instance_id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus item ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Akhir wrapper dengan scroll -->
                <div class="mt-4">
                    <a href="{{ route('items.index') }}" class="text-blue-600 hover:text-blue-900">Kembali ke Daftar Barang</a>
                </div>
            </div>
        </div>
    </div>
</x-layout>