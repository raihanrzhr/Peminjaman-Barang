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
}
