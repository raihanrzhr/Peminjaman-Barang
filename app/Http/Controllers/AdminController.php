<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::all();
        return view('admins', ['title' => 'Tabel Admin', 'admins' => $admins]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'admin_name' => 'required|string|max:255',
        ]);

        $admin = new Admin();
        $admin->admin_name = $request->admin_name;
        $admin->save();

        return redirect()->route('admins.index')->with('success', 'Admin berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        return view('edit_admin', ['admin' => $admin]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'admin_name' => 'required|string|max:255',
        ]);

        $admin = Admin::findOrFail($id);
        $admin->admin_name = $request->admin_name;
        $admin->save();

        return redirect()->route('admins.index')->with('success', 'Admin berhasil diupdate!');
    }

    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();

        return redirect()->route('admins.index')->with('success', 'Admin berhasil dihapus!');
    }
}
