<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return view('items', ['title' => 'Tabel Barang', 'items' => $items]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'namaBarang' => 'required|string|max:255',
            'spesifikasi' => 'required|string',
        ]);

        $item = new Item();
        $item->nama_barang = $request->namaBarang;
        $item->spesifikasi = $request->spesifikasi;
        $item->save();

        return redirect()->route('items.index')->with('success', 'Item berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $item = Item::findOrFail($id);
        return view('edit_item', ['item' => $item]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'namaBarang' => 'required|string|max:255',
            'spesifikasi' => 'required|string',
        ]);

        $item = Item::findOrFail($id);
        $item->nama_barang = $request->namaBarang;
        $item->spesifikasi = $request->spesifikasi;
        $item->save();

        return redirect()->route('items.index')->with('success', 'Item berhasil diupdate!');
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        return redirect()->route('items.index')->with('success', 'Item berhasil dihapus!');
    }
}
