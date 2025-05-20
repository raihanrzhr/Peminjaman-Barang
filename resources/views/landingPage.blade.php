<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Barang Tersedia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
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
    <div class="max-w-7xl mx-auto mt-10 bg-white rounded-xl shadow p-8">
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
                            <th class="px-6 py-3 border-b border-slate-200 text-left font-semibold text-slate-700">Nama Barang</th>
                            <th class="px-4 py-3 border-b border-slate-200 text-left font-semibold text-slate-700">Spesifikasi</th>
                            <th class="px-4 py-3 border-b border-slate-200 text-left font-semibold text-slate-700">Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                            @php
                                // Kelompokkan spesifikasi dan hitung quantity
                                $specGroups = collect($item->itemInstances)
                                    ->where('status', 'Available')
                                    ->groupBy('specifications')
                                    ->map(function($group) {
                                        return $group->count();
                                    });
                            @endphp
                            @if($specGroups->count())
                                @foreach($specGroups as $spec => $qty)
                                    <tr class="hover:bg-slate-50">
                                        <td class="px-4 py-3 border-b border-slate-200 align-top item-name">
                                            {{ $item->item_name }}
                                        </td>
                                        <td class="px-4 py-3 border-b border-slate-200 item-spec">
                                            {{ $spec ?: '-' }}
                                        </td>
                                        <td class="px-4 py-3 border-b border-slate-200 text-center">
                                            {{ $qty }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="px-4 py-3 border-b border-slate-200 align-top item-name">{{ $item->item_name }}</td>
                                    <td class="px-4 py-3 border-b border-slate-200 item-spec text-slate-400">-</td>
                                    <td class="px-4 py-3 border-b border-slate-200 text-center">0</td>
                                </tr>
                            @endif
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