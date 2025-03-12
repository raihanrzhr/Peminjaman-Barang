<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrower;

class BorrowerController extends Controller
{
    public function index()
    {
        $borrowers = Borrower::all();
        return view('borrowers', ['title' => 'Tabel Peminjam', 'names' => $borrowers]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'spesifikasi' => 'required|string',
        ]);

        $borrower = new Borrower();
        $borrower->nama = $request->nama;
        $borrower->keterangan = $request->spesifikasi;
        $borrower->save();

        return redirect()->route('borrowers')->with('success', 'Peminjam berhasil ditambahkan!');
    }
}
