<div class="fixed bottom-4 right-4 z-50">
    <!-- Floating Menu -->
    <div id="floatingMenu" class="hidden space-y-2">
        <a href="{{ route('peminjaman.create') }}" class="flex items-center gap-2 px-4 py-2 bg-white rounded-lg shadow-lg hover:bg-gray-100 transition-colors">
            <i class="fas fa-handshake"></i>
            <span>Tambah Peminjaman</span>
        </a>
        <a href="{{ route('barang.create') }}" class="flex items-center gap-2 px-4 py-2 bg-white rounded-lg shadow-lg hover:bg-gray-100 transition-colors">
            <i class="fas fa-box"></i>
            <span>Tambah Barang</span>
        </a>
        <a href="{{ route('peminjam.create') }}" class="flex items-center gap-2 px-4 py-2 bg-white rounded-lg shadow-lg hover:bg-gray-100 transition-colors">
            <i class="fas fa-user-plus"></i>
            <span>Tambah Peminjam</span>
        </a>
    </div>

    <!-- Toggle Button -->
    <button id="toggleMenu" class="w-12 h-12 bg-blue-500 text-white rounded-full shadow-lg hover:bg-blue-600 transition-colors flex items-center justify-center text-2xl">
        +
    </button>
</div>

<script>
    document.getElementById('toggleMenu').addEventListener('click', function() {
        const menu = document.getElementById('floatingMenu');
        menu.classList.toggle('hidden');
    });
</script>