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

        // Check if the item already exists
        $item = Item::where('item_name', $request->item_name)
                    ->first();

        if ($item) {
            // If item exists, update the quantity
            $item->quantity += $request->quantity;
            $item->save();
        } else {
            // If item does not exist, create a new item
            $item = Item::create([
                'item_name' => $request->item_name,
                'category' => $request->category,
                'quantity' => $request->quantity,
            ]);
        }

        // Add item instances
        for ($i = 0; $i < $request->quantity; $i++) {
            foreach ($request->specifications as $specification) {
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
        $request->validate([
            'item_name' => 'required|string|max:255',
            'specifications' => 'required|array',
            'category' => 'required|string',
            'quantity' => 'required|integer',
        ]);

        $item = Item::findOrFail($id);
        $item->update([
            'item_name' => $request->item_name,
            'category' => $request->category,
            'quantity' => $request->quantity,
        ]);

        // Update item instances
        $item->itemInstances()->delete();
        foreach ($request->specifications as $specification) {
            ItemInstance::create([
                'item_id' => $item->item_id,
                'specifications' => $specification,
                'date_added' => now(),
                'status' => 'Available',
                'condition_status' => 'Good',
            ]);
        }

        return redirect()->route('items.index')->with('success', 'Barang berhasil diupdate!');
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        return redirect()->route('items.index')->with('success', 'Barang berhasil dihapus!');
    }

    public function show($id)
    {
        $itemDetails = DB::table('item_details')->where('item_id', $id)->get();
        $title = 'Detail Barang';
        return view('item_detail', compact('itemDetails', 'title'));
    }
}
