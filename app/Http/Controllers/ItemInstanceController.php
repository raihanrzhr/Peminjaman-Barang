<?php

namespace App\Http\Controllers;

use App\Models\ItemInstance;
use Illuminate\Http\Request;

class ItemInstanceController extends Controller
{
    public function edit($id)
    {
        $itemInstance = ItemInstance::findOrFail($id);
        $title = 'Edit Barang';
        return view('edit_item', compact('itemInstance', 'title'));
    }

    public function destroy($id)
    {
        $itemInstance = ItemInstance::findOrFail($id);

        // Kurangi quantity di tabel items
        $item = $itemInstance->item;
        if ($item) {
            $item->decrement('quantity');
        }

        // Hapus instance barang
        $itemInstance->delete();

        return redirect()->route('items.index')->with('success', 'Item berhasil dihapus.');
    }
}