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
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ItemInstanceController;

Route::get('/', [BorrowingController::class, 'index'])->name('borrowings.index');

Route::get('/items', [ItemController::class, 'index'])->name('items.index');
Route::post('/items', [ItemController::class, 'store'])->name('items.store');
Route::get('/items/{id}/edit', [ItemController::class, 'edit'])->name('items.edit');
Route::put('/items/{id}', [ItemController::class, 'update'])->name('items.update');
Route::delete('/items/{id}', [ItemController::class, 'destroy'])->name('items.destroy');
Route::get('/items/{id}/detail', [ItemController::class, 'show'])->name('items.detail');

Route::get('/borrowers', [BorrowerController::class, 'index'])->name('borrowers.index');
Route::get('/borrowers/{id}/edit', [BorrowerController::class, 'edit'])->name('borrowers.edit');
Route::put('/borrowers/{id}', [BorrowerController::class, 'update'])->name('borrowers.update');
Route::delete('/borrowers/{id}', [BorrowerController::class, 'destroy'])->name('borrowers.destroy');
Route::post('/borrowers/store', [BorrowerController::class, 'store'])->name('borrowers.store');

Route::post('/borrowings/update/{id}', [BorrowingController::class, 'updateStatus']);
Route::post('/borrowings/store', [BorrowingController::class, 'store'])->name('borrowings.store');
Route::get('/borrowings/create', [BorrowingController::class, 'create'])->name('borrowings.create');
Route::get('/borrowings/{id}/edit', [BorrowingController::class, 'edit'])->name('borrowings.edit');
Route::put('/borrowings/{id}', [BorrowingController::class, 'update'])->name('borrowings.update');
Route::delete('/borrowings/{id}', [BorrowingController::class, 'destroy'])->name('borrowings.destroy');

Route::get('/items/add_items', function () {
    return view('add_items', ['title' => 'Tambah Barang']);
})->name('add_items');

Route::get('/borrowers/add_borrowers', function () {
    return view('add_borrowers', ['title' => 'Tambah Peminjam']);
})->name('add_borrowers');

Route::get('/borrowings/add_borrowings', [BorrowingController::class, 'create'])->name('add_borrowings');

// Routes for Admin
Route::get('/admins', [AdminController::class, 'index'])->name('admins.index');
Route::post('/admins', [AdminController::class, 'store'])->name('admins.store');
Route::get('/admins/create', [AdminController::class, 'create'])->name('admins.create'); // Tambahkan rute ini
Route::get('/admins/{id}/edit', [AdminController::class, 'edit'])->name('admins.edit');
Route::put('/admins/{id}', [AdminController::class, 'update'])->name('admins.update');
Route::delete('/admins/{id}', [AdminController::class, 'destroy'])->name('admins.destroy');

Route::get('/item_instances/{id}/edit', [ItemInstanceController::class, 'edit'])->name('item_instances.edit');
Route::put('/item_instances/{id}', [ItemInstanceController::class, 'update'])->name('item_instances.update');

Route::get('item_instances/{id}/edit', [ItemInstanceController::class, 'edit'])->name('item_instances.edit');
Route::delete('/item-instances/{id}', [ItemInstanceController::class, 'destroy'])->name('item_instances.destroy');
