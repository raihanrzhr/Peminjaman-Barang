<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\ItemInstance;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with('itemInstances')->get();
        $title = 'Tabel Barang';
        return view('items', compact('items', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'category' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'specifications' => 'required|array',
        ]);

        $item = Item::firstOrCreate(
            ['item_name' => $request->item_name],
            ['category' => $request->category, 'quantity' => 0]
        );

        $item->increment('quantity', $request->quantity);

        foreach ($request->specifications as $specification) {
            for ($i = 0; $i < $request->quantity; $i++) {
                ItemInstance::create([
                    'item_id' => $item->item_id,
                    'specifications' => $specification,
                    'date_added' => now(),
                    'status' => 'Available',
                    'condition_status' => 'Good',
                ]);
            }
        }

        return redirect()->route('items.index')->with('success', 'Barang berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $itemInstance = ItemInstance::findOrFail($id);
        $title = 'Edit Barang';
        return view('edit_item', compact('itemInstance', 'title'));
    }

    public function update(Request $request, $id)
    {
        $itemInstance = ItemInstance::findOrFail($id);

        if ($request->has('condition_status') && !$request->has('specifications')) {
            $request->validate([
                'condition_status' => 'required|string|in:Good,Damaged',
            ]);

            $itemInstance->condition_status = $request->condition_status;
            $itemInstance->status = $request->condition_status === 'Damaged' ? 'Unavailable' : 'Available';
            $itemInstance->save();

            return redirect()->back()->with('success', 'Status kondisi berhasil diperbarui.');
        }

        $request->validate([
            'condition_status' => 'required|string|in:Good,Damaged',
            'specifications' => 'required|string',
        ]);

        $itemInstance->update([
            'condition_status' => $request->condition_status,
            'specifications' => $request->specifications,
            'status' => $request->condition_status === 'Damaged' ? 'Unavailable' : 'Available',
        ]);

        return redirect()->route('items.detail', $itemInstance->item_id)
                         ->with('success', 'Item berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $itemInstance = ItemInstance::findOrFail($id);

        if ($itemInstance->item) {
            $itemInstance->item->decrement('quantity');
        }

        $itemInstance->delete();

        return redirect()->route('items.detail', $itemInstance->item_id)->with('success', 'Item berhasil dihapus.');
    }

    public function show($id)
    {
        $itemDetails = DB::table('item_details')->where('item_id', $id)->get();
        $title = 'Detail Barang';
        return view('item_detail', compact('itemDetails', 'title'));
    }
}
