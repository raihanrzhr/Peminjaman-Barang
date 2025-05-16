<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="parent">
        <x-notification />
        
        <div class="div1">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="overflow-y-auto max-h-96 border rounded-md border-gray-300">
                    <table class="min-w-full border border-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">No</th>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Nama</th>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">NIP</th>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Role</th>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($admins as $index => $admin)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center">{{ $admin->admin_name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center">{{ $admin->NIP }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center">{{ $admin->role }}</td>
                                    <td class="px-1 py-4 text-sm text-center relative">
                                        <div x-data="{ open: false }" class="inline-block">
                                            <button @click="open = !open" class="p-1 border border-gray-300 rounded-md hover:bg-gray-200 focus:outline-none">
                                                <!-- Meatballs icon (horizontal dots) -->
                                                <svg class="w-5 h-5 text-gray-800" fill="currentColor" viewBox="0 0 24 24">
                                                    <circle cx="6" cy="12" r="1.5"/>
                                                    <circle cx="12" cy="12" r="1.5"/>
                                                    <circle cx="18" cy="12" r="1.5"/>
                                                </svg>
                                            </button>
                                            <div x-show="open" @click.away="open = false"
                                                 class="absolute right-0 z-20 mt-2 w-36 bg-white border border-gray-300 rounded-lg shadow-lg py-1 transition">
                                                 <a href="{{ route('admins.edit', $admin->admin_id) }}"
                                                   class="block px-4 py-2 text-sm text-blue-700 border border-transparent rounded-md m-1 hover:bg-blue-50 hover:text-blue-900 hover:border-blue-400 transition">
                                                    Edit
                                                </a>
                                                <button type="button"
                                                    class="block px-11.5 py-2 text-sm text-red-700 border border-transparent rounded-md m-1 hover:bg-red-50 hover:text-red-900 hover:border-red-400 transition"
                                                    onclick="confirmDelete('{{ route('admins.destroy', $admin->admin_id) }}')">
                                                    Delete
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="div2">
            <button class="btn-tambah" onclick="window.location='{{ route('admins.create') }}'">Add Admin</button>
        </div>
        <div class="div3">
            
        </div>
    </div>
</x-layout>