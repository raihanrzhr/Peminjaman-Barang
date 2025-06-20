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
        $items = Item::withCount('itemInstances')->paginate(20);
        $title = 'Tabel Barang';
        return view('items', compact('items', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string',
            'item_name' => 'required|string',
            'specifications' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        // Cari atau buat kategori
        $item = Item::firstOrCreate(['category' => $request->category]);

        // Tambahkan instance sebanyak quantity
        for ($i = 0; $i < $request->quantity; $i++) {
            ItemInstance::create([
                'item_id' => $item->item_id,
                'item_name' => ucwords(trim($request->item_name)),
                'specifications' => $request->specifications,
                'date_added' => now(),
                'status' => 'Available',
                'condition_status' => 'Good',
            ]);
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
            'id_barang' => 'nullable|integer', // Validasi untuk id_barang
        ]);

        $itemInstance->update([
            'condition_status' => $request->condition_status,
            'item_name' => ucwords(trim($request->item_name)),
            'specifications' => $request->specifications,
            'id_barang' => $request->id_barang, // Perbarui id_barang jika ada
            'status' => $request->condition_status === 'Damaged' ? 'Unavailable' : 'Available',
        ]);

        return redirect()->route('items.detail', $itemInstance->item_id)
                         ->with('success', 'Item berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $itemInstance = ItemInstance::findOrFail($id);

        $itemInstance->delete();

        return true;
    }

    public function destroyAll($id)
    {
        $item = Item::findOrFail($id);
        // Menghapus semua ItemInstance terkait
        $itemInstances = $item->itemInstances;
        foreach ($itemInstances as $itemInstance) {
            $itemInstance->delete();
        }

        // Menghapus item
        $item->delete();

        return true
        // redirect()->route('items.index')->with('success', 'Semua instance item dan item berhasil dihapus.')
        ;
    }

    public function show($id)
    {
        $itemDetails = ItemInstance::where('item_id', $id)->paginate(30);
        $availableCount = $itemDetails->where('status', 'Available')->count();
        $title = 'Detail Barang';
        return view('item_detail', compact('itemDetails', 'title', 'availableCount'));
    }

    public function create()
    {
        $categories = Item::all(); // Ambil semua kategori dari tabel items
        return view('add_items', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'category' => 'required|string|unique:items,category',
        ]);
        Item::firstOrCreate(['category' => ucwords(trim($request->category))]);
        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan!');
    }
}
