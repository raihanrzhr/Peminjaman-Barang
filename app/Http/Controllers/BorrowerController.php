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
            'keterangan' => 'required|string',
        ]);

        $borrower = new Borrower();
        $borrower->nama = $request->nama;
        $borrower->keterangan = $request->keterangan;
        $borrower->save();

        return redirect()->route('borrowers')->with('success', 'Peminjam berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $borrower = Borrower::findOrFail($id);
        return view('edit_borrower', ['borrower' => $borrower]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'keterangan' => 'required|string',
        ]);

        $borrower = Borrower::findOrFail($id);
        $borrower->nama = $request->nama;
        $borrower->keterangan = $request->keterangan;
        $borrower->save();

        return redirect()->route('borrowers')->with('success', 'Peminjam berhasil diupdate!');
    }

    public function destroy($id)
    {
        $borrower = Borrower::findOrFail($id);
        $borrower->delete();

        return redirect()->route('borrowers')->with('success', 'Peminjam berhasil dihapus!');
    }
}
