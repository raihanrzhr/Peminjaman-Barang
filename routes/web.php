<?php

use App\Models\Item;
use App\Models\Borrow;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;



Route::get('/', function () {
    return view('peminjaman', ['title' => 'Tabel Peminjaman']);
});

Route::get('/items', function () {
    return view('items', ['title' => 'Tabel Barang', 'items' => Item::all()]);
});

// Route::get('/items/{id}', function ($id) {
//     \Log::info("Mencari item dengan ID: {$id}");
//     $items = Item::find($id);
    
//     if (empty($items)) {
//         \Log::info("Item dengan ID {$id} tidak ditemukan.");
//         return redirect('/items')->with('error', 'Item tidak ditemukan.');
//     }
    
//     return view('item', ['title' => 'Detail Barang', 'item' => $items]);
// });

Route::get('/borrowers', function () {
    return view('borrowers', ['title' => 'Tabel Peminjam', 'names' => Borrow::all()]);
});

Route::get('/items/add_items', function () {
    return view('add_items', ['title' => 'Tambah Barang']);
})->name('add_items');

Route::get('/borrowers/add_borrowers', function () {
    return view('add_borrowers', ['title' => 'Tambah Peminjam']);
})->name('add_borrowers');

Route::post('/items', [ItemController::class, 'store'])->name('items.store');