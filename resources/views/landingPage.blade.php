<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Barang Tersedia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" href="{{ asset('images/ITB_white.png') }}" type="image/png">
    <script src="{{ asset('js/script.js') }}"></script>
</head>
<body class="bg-gradient-to-br from-blue-400 via-white to-blue-200 min-h-screen">
    <!-- Tombol Login di kanan atas -->
    <div class="w-full flex justify-end items-center pt-6 pr-10">
        <a href="{{ route('login') }}" class="flex items-center gap-1.5 text-slate-900 font-medium text-lg hover:underline">
            Log in
            <span class="text-xl">&#8594;</span>
        </a>
    </div>

    <!-- Hero Section -->
    <section class="max-w-7xl mx-auto mt-10 mb-16 bg-white rounded-xl shadow p-10 flex flex-col md:flex-row items-center gap-8">
        <div class="flex-1">
            <h1 class="text-4xl md:text-5xl font-extrabold text-blue-700 mb-4 leading-tight">
                Lorem ipsum dolor sit amet consectetur
            </h1>
            <p class="text-lg text-slate-600 mb-6">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloribus dolore aliquid odit rem voluptatum qui natus eaque autem, recusandae aperiam repudiandae animi, quod, minima molestiae similique esse debitis quidem saepe.
            </p>
            <a href="#daftar-barang" class="inline-block px-6 py-3 bg-blue-700 text-white rounded-lg font-semibold shadow hover:bg-blue-800 transition">
                Lihat Daftar Barang
            </a>
        </div>
        <div class="flex-1 flex justify-center">
            <img src="{{ asset('images/Logo_Institut_Teknologi_Bandung.png') }}" alt="Peminjaman Barang" class="w-64 h-64 object-contain mr-[-90px]">
        </div>
    </section>

    <div id="daftar-barang" class="max-w-7xl mx-auto mt-10 bg-white rounded-xl shadow p-8 mb-10">
        <h1 class="text-2xl font-bold text-blue-700 mb-6">Daftar Barang Tersedia</h1>
        
        <!-- Search box -->
        <div class="mb-6">
            <input
                type="text"
                id="searchInput"
                placeholder="Cari nama barang..."
                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
            >
        </div>

        @if($items->count())
            <div class="overflow-x-auto overflow-y-auto max-h-[500px]">
                <table class="min-w-full border border-slate-200 rounded-lg" id="itemsTable">
                    <thead>
                        <tr class="bg-slate-100">
                            <th class="px-6 py-3 border-b border-slate-200 text-left font-semibold text-slate-700">Kategori</th>
                            <th class="px-6 py-3 border-b border-slate-200 text-left font-semibold text-slate-700">Nama Barang</th>
                            <th class="px-4 py-3 border-b border-slate-200 text-left font-semibold text-slate-700">Spesifikasi</th>
                            <th class="px-4 py-3 border-b border-slate-200 text-left font-semibold text-slate-700">Jumlah Tersedia</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                            @php
                                // Kelompokkan instance yang tersedia berdasarkan nama dan spesifikasi
                                $groups = collect($item->itemInstances)
                                    ->where('status', 'Available')
                                    ->groupBy(function($instance) {
                                        return $instance->item_name . '||' . $instance->specifications;
                                    });
                            @endphp
                            @foreach($groups as $key => $group)
                                @php
                                    [$itemName, $spec] = explode('||', $key);
                                @endphp
                                <tr class="hover:bg-slate-50">
                                    <td class="px-4 py-3 border-b border-slate-200 align-top">{{ $item->category }}</td>
                                    <td class="px-4 py-3 border-b border-slate-200 align-top item-name">{{ $itemName }}</td>
                                    <td class="px-4 py-3 border-b border-slate-200 item-spec">{{ $spec ?: '-' }}</td>
                                    <td class="px-4 py-3 border-b border-slate-200 text-center">{{ $group->count() }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-slate-500">Tidak ada barang yang tersedia saat ini.</p>
        @endif
    </div>
</body>
</html>