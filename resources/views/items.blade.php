<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="parent">
        <div class="div1">
            <table class="min-w-full border-collapse border border-gray-300">
                <thead>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2">ID</th>
                        <th class="border border-gray-300 px-4 py-2">Nama Barang</th>
                        <th class="border border-gray-300 px-4 py-2">Spesifikasi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">{{ $item['id'] }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $item['namaBarang'] }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $item['spesifikasi'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="div2">

        </div>
        <div class="div3">

        </div>
    </div>
</x-layout>