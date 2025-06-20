<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::paginate(20);
        $title = 'Daftar Penanggung Jawab';
        return view('admins', compact('admins', 'title'));
    }

    public function create()
    {
        $title = 'Tambah Admin';
        return view('add_admin', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'admin_name' => 'required|string|max:255',
            'role' => 'required|integer|in:0,1',
            'NIP' => 'nullable|integer',
        ]);

        $data = $request->all();
        $data['admin_name'] = ucwords(trim($data['admin_name']));

        Admin::create($data);

        return redirect()->route('admins.index')->with('success', 'Admin berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        $title = 'Edit Admin';
        return view('edit_admin', compact('admin', 'title'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'admin_name' => 'required|string|max:255',
            'role' => 'required|integer|in:0,1',
            'NIP' => 'nullable|integer',
        ]);

        $data = $request->all();
        $data['admin_name'] = ucwords(trim($data['admin_name']));

        $admin = Admin::findOrFail($id);
        $admin->update($data);

        return redirect()->route('admins.index')->with('success', 'Admin berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();

        return true
        // redirect()->route('admins.index')->with('success', 'Admin berhasil dihapus!')
        ;
    }
}
