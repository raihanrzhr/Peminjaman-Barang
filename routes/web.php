<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('peminjaman', ['title' => 'Tabel Peminjaman']);
});

Route::get('/barang', function () {
    return view('barang', ['title' => 'Tabel Barang']);
});

Route::get('/peminjam', function () {
    return view('peminjam', ['title' => 'Tabel Peminjam']);
});