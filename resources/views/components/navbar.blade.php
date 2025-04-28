<nav class="bg-gray-800" x-data="{ isOpen: false }">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center">
                <div class="shrink-0">
                    <img class="size-8" src="https://tailwindui.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company">
                </div>
                <div class="hidden md:block">
                    <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="/" class="{{ request()->is('/') ?                  'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium" aria-current="page">Tabel Peminjaman</a>
                        <a href="/items" class="{{ request()->is('items') ?         'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium ">Tabel Barang</a>
                        <a href="/borrowers" class="{{ request()->is('borrowers') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium ">Tabel Peminjam</a>
                        <a href="/admins" class="{{ request()->is('admins') ?       'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium ">Penanggung Jawab</a>
                    </div>
                </div>
            </div>
            {{-- button logout dekstop --}}
            <form action="{{ route('logout') }}" method="POST" class="hidden md:block">
                @csrf
                <button type="submit" class="relative rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                    <span class="sr-only">Logout</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25a2.25 2.25 0 0 0-2.25-2.25h-6a2.25 2.25 0 0 0-2.25 2.25v13.5a2.25 2.25 0 0 0 2.25 2.25h6a2.25 2.25 0 0 0 2.25-2.25V15M9 12h12m0 0-3-3m3 3-3 3" />
                    </svg>
                </button>
            </form>
            {{-- mobile menu button --}}
            <div class="-mr-2 flex md:hidden">
                <!-- Logout Button -->
                <form action="{{ route('logout') }}" method="POST" class="relative rounded-full bg-gray-800 p-2 text-gray-400 hover:text-white hover:bg-gray-700 focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                    @csrf
                    <button type="submit" class="flex items-center">
                        <span class="sr-only">Logout</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25a2.25 2.25 0 0 0-2.25-2.25h-6a2.25 2.25 0 0 0-2.25 2.25v13.5a2.25 2.25 0 0 0 2.25 2.25h6a2.25 2.25 0 0 0 2.25-2.25V15M9 12h12m0 0-3-3m3 3-3 3" />
                        </svg>
                    </button>
                </form>

                <!-- Mobile Menu Toggle -->
                <button type="button" @click="isOpen = !isOpen" 
                    class="relative inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 focus:outline-hidden" aria-controls="mobile-menu" aria-expanded="false">
                    <span class="absolute -inset-0.5"></span>
                    <span class="sr-only">Open main menu</span>
                    <!-- Menu open: "hidden", Menu closed: "block" -->
                    <svg :class="{'hidden': isOpen, 'block': !isOpen }"
                    class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <!-- Menu open: "block", Menu closed: "hidden" -->
                    <svg :class="{'block': isOpen, 'hidden': !isOpen }"
                    class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div class="md:hidden" id="mobile-menu" 
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-100 transform"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75 transform"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 mt-2 w-56 origin-top-right rounded-md shadow-lg">
        <div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
            <a href="/"             class="{{ request()->is('/') ?  'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'}} block rounded-md px-3 py-2 text-base font-medium" aria-current="page">Tabel Peminjaman</a>
            <a href="/items"        class="{{ request()->is('items') ?  'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'}} block rounded-md px-3 py-2 text-base font-medium">Tabel Barang</a>
            <a href="/borrowers"    class="{{ request()->is('borrowers') ?  'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'}} block rounded-md px-3 py-2 text-base font-medium">Tabel Peminjam</a>
            <a href="/admins"       class="{{ request()->is('admins') ?  'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'}} block rounded-md px-3 py-2 text-base font-medium">Penanggung Jawab</a>
        </div>
    </div>
</nav>