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

    public function update(Request $request, $id)
    {
        $itemInstance = ItemInstance::findOrFail($id);

        // Validasi untuk dropdown (hanya condition_status)
        if ($request->has('condition_status') && !$request->has('specifications')) {
            $request->validate([
                'condition_status' => 'required|string|in:Good,Damaged',
            ]);

            $itemInstance->condition_status = $request->condition_status;

            // Perbarui status jika condition_status adalah Damaged
            if ($request->condition_status === 'Damaged') {
                $itemInstance->status = 'Unavailable';
            } else {
                $itemInstance->status = 'Available'; // Atur kembali ke Available jika Good
            }

            $itemInstance->save();

            return redirect()->back()->with('success', 'Status kondisi berhasil diperbarui.');
        }

        // Validasi untuk edit_item (condition_status dan specifications)
        $request->validate([
            'condition_status' => 'required|string|in:Good,Damaged',
            'specifications' => 'required|string',
        ]);

        $itemInstance->condition_status = $request->condition_status;
        $itemInstance->specifications = $request->specifications;

        // Perbarui status jika condition_status adalah Damaged
        if ($request->condition_status === 'Damaged') {
            $itemInstance->status = 'Unavailable';
        } else {
            $itemInstance->status = 'Available'; // Atur kembali ke Available jika Good
        }

        $itemInstance->save();

        return redirect()->route('items.detail', $itemInstance->item_id)
                         ->with('success', 'Item berhasil diperbarui.');
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