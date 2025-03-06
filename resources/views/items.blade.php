<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    @foreach ($items as $item)
        <article class="py-8 max-w-screen-md border-b border-gray-300">
            <h2 class="mb-1 text-3xl tracking-tight font-bold text-gray-900">{{ $item['namaBarang'] }}</h2>
            <div class="text-base text-gray-600">
                <a href="">{{ $item['peminjam'] }}</a> | 1 januari 2025
            </div>
            <p class="my-4 font-light">{{ $item['deskripsi'] }}</p>
        </article>
    @endforeach
</x-layout>