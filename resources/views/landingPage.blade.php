<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Barang Tersedia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
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
                Selamat Datang di Sistem Peminjaman Barang ITB
            </h1>
            <p class="text-lg text-slate-600 mb-6">
                Pinjam berbagai barang kebutuhan Anda dengan mudah, cepat, dan transparan. Temukan daftar barang yang tersedia tanpa ribet.
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
        
        {{-- Search form --}}
        <form method="GET" action="{{ url()->current() }}" class="mb-6 flex gap-2">
            <input
                type="text"
                name="q"
                value="{{ request('q') }}"
                placeholder="Cari nama barang..."
                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
            >
            @if(request('q'))
                <a href="{{ url()->current() }}" class="px-4 py-2 bg-gray-200 rounded-lg text-gray-700 hover:bg-gray-300 transition">
                    Clear
                </a>
            @endif
        </form>

        @if($items->count())
            <div class="overflow-x-auto overflow-y-auto max-h-[500px] rounded-lg">
                <table class="min-w-full border border-slate-300 rounded-lg" id="itemsTable">
                    <thead>
                        <tr class="bg-slate-100">
                            <th class="sticky top-0 z-10 bg-slate-100 px-6 py-3 border-b border-r border-slate-300 text-center font-semibold text-slate-700">Kategori</th>
                            <th class="sticky top-0 z-10 bg-slate-100 px-6 py-3 border-b border-r border-slate-300 text-center font-semibold text-slate-700">Nama Barang</th>
                            <th class="sticky top-0 z-10 bg-slate-100 px-4 py-3 border-b border-r border-slate-300 text-center font-semibold text-slate-700">Spesifikasi</th>
                            <th class="sticky top-0 z-10 bg-slate-100 px-4 py-3 border-b border-r border-slate-300 text-center font-semibold text-slate-700">Jumlah Tersedia</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 border-b border-r border-slate-300 align-top">{{ $item->category }}</td>
                                <td class="px-4 py-3 border-b border-r border-slate-300 align-top item-name">{{ $item->item_name }}</td>
                                <td class="px-4 py-3 border-b border-r border-slate-300 item-spec">{{ $item->specifications ?: '-' }}</td>
                                <td class="px-4 py-3 border-b border-r border-slate-300 text-center">{{ $item->jumlah_tersedia }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{-- Tambahkan ini untuk pagination --}}
            <div class="mt-6">
                {{ $items->links() }}
            </div>
        @else
            <p class="text-slate-500">Tidak ada barang yang tersedia saat ini.</p>
        @endif
    </div>
</body>
</html>