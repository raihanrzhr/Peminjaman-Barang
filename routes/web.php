<?php

use App\Models\Item;
use App\Models\Borrower;
use App\Models\Borrowing;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\BorrowerController;

Route::get('/', function () {
    return view('borrowings', ['title' => 'Tabel Peminjaman', 'borrowings' => Borrowing::all()]);
});

Route::get('/items', [ItemController::class, 'index'])->name('items.index');
Route::post('/items', [ItemController::class, 'store'])->name('items.store');
Route::get('/items/{id}/edit', [ItemController::class, 'edit'])->name('items.edit');
Route::put('/items/{id}', [ItemController::class, 'update'])->name('items.update');
Route::delete('/items/{id}', [ItemController::class, 'destroy'])->name('items.destroy');

Route::get('/borrowers', [BorrowerController::class, 'index'])->name('borrowers');
Route::get('/borrowers/{id}/edit', [BorrowerController::class, 'edit'])->name('borrowers.edit');
Route::put('/borrowers/{id}', [BorrowerController::class, 'update'])->name('borrowers.update');
Route::delete('/borrowers/{id}', [BorrowerController::class, 'destroy'])->name('borrowers.destroy');

Route::get('/items/add_items', function () {
    return view('add_items', ['title' => 'Tambah Barang']);
})->name('add_items');

Route::get('/borrowers/add_borrowers', function () {
    return view('add_borrowers', ['title' => 'Tambah Peminjam']);
})->name('add_borrowers');

Route::get('/borrowings', [BorrowingController::class, 'index'])->name('borrowings.index');
Route::post('/borrowings/update/{id}', [BorrowingController::class, 'updateStatus']);
Route::post('/borrowers/store', [BorrowerController::class, 'store'])->name('borrowers.store');