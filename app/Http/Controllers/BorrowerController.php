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
            'name' => 'required|string|max:255',
            'nip_nopeg_nim' => 'required|string|max:50|unique:borrowers',
            'description' => 'required|string',
        ]);

        $borrower = new Borrower();
        $borrower->name = $request->name;
        $borrower->nip_nopeg_nim = $request->nip_nopeg_nim;
        $borrower->description = $request->description;
        $borrower->save();

        return redirect()->route('borrowers.index')->with('success', 'Peminjam berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $borrower = Borrower::findOrFail($id);
        return view('edit_borrower', ['borrower' => $borrower]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nip_nopeg_nim' => 'required|string|max:50|unique:borrowers,nip_nopeg_nim,' . $id . ',borrower_id',
            'description' => 'required|string',
        ]);

        $borrower = Borrower::findOrFail($id);
        $borrower->name = $request->name;
        $borrower->nip_nopeg_nim = $request->nip_nopeg_nim;
        $borrower->description = $request->description;
        $borrower->save();

        return redirect()->route('borrowers.index')->with('success', 'Peminjam berhasil diupdate!');
    }

    public function destroy($id)
    {
        $borrower = Borrower::findOrFail($id);
        $borrower->delete();

        return redirect()->route('borrowers.index')->with('success', 'Peminjam berhasil dihapus!');
    }
}
