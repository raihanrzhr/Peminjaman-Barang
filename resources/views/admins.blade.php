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
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Role</th>
                                <th class="px-6 py-3 text-center text-sm font-medium text-gray-900 border-b border-r border-gray-300">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($admins as $index => $admin)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center">{{ $admin->admin_name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 border-b border-r border-gray-300 text-center">{{ $admin->role }}</td>
                                    <td class="px-6 py-4 text-sm text-center">
                                        <a href="{{ route('admins.edit', $admin->admin_id) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                        <button type="button" class="text-red-600 hover:text-red-900" onclick="confirmDelete('{{ route('admins.destroy', $admin->admin_id) }}')">Delete</button>
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