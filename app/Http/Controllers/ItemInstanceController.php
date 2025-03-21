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
}