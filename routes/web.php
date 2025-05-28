<?php

use App\Models\Item;
use App\Models\Borrower;
use App\Models\Borrowing;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\BorrowerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ItemInstanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;

// Landing page untuk semua user
Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    // Items
    Route::resource('items', ItemController::class)->except(['show']);
    Route::get('/items/{id}/detail', [ItemController::class, 'show'])->name('items.detail');
    Route::delete('/items/{id}/destroyAll', [ItemController::class, 'destroyAll'])->name('items.destroyAll');
    Route::get('/items/add_items', [ItemController::class, 'create'])->name('add_items');

    // Borrowers
    Route::resource('borrowers', BorrowerController::class)->except(['show', 'create']);
    Route::get('/borrowers/add_borrowers', function () {
        return view('add_borrowers', ['title' => 'Tambah Peminjam']);
    })->name('add_borrowers');

    // Borrowings
    Route::resource('borrowings', BorrowingController::class)->except(['show']);
    Route::get('/borrowings/{id}/detail', [BorrowingController::class, 'detail'])->name('borrowings.detail');
    Route::post('/borrowings/update/{id}', [BorrowingController::class, 'updateStatus']);
    Route::post('/borrowings/update-status/{id}', [BorrowingController::class, 'updateStatus'])->name('borrowings.updateStatus');
    Route::post('/borrowings/upload-proof/{id}/{type}', [BorrowingController::class, 'uploadProof'])->name('borrowings.uploadProof');
    Route::delete('/borrowings/delete-proof/{id}/{type}', [BorrowingController::class, 'deleteProof'])->name('borrowings.deleteProof');
    Route::get('/borrowings/add_borrowings', [BorrowingController::class, 'create'])->name('add_borrowings');

    // Admins
    Route::resource('admins', AdminController::class)->except(['show']);
    
    // Route untuk menyimpan kategori item
    Route::post('/categories/store', [ItemController::class, 'storeCategory'])->name('categories.store');
});