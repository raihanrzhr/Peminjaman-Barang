<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Item;
use App\Models\Borrower;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::getBorrowings();
        $title = 'Tabel Peminjaman';
        return view('borrowings', compact('borrowings', 'title'));
    }

    public function updateStatus(Request $request, $id)
    {
        \Log::info('Update status called', ['id' => $id, 'status' => $request->status]);

        $borrowing = Borrowing::find($id);
        if (!$borrowing) {
            return response()->json(['success' => false, 'message' => 'Borrowing not found'], 404);
        }

        if ($request->status === 'Dikembalikan') {
            $borrowing->tanggal_kembali = now(); // Atur tanggal kembali ke waktu sekarang
        } else {
            $borrowing->tanggal_kembali = null; // Set tanggal kembali menjadi NULL
        }

        try {
            $borrowing->save();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error('Error updating borrowing status', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Error updating status'], 500);
        }
    }

    public function create()
    {
        $items = Item::whereDoesntHave('borrowings', function ($query) {
            $query->whereNull('tanggal_kembali');
        })->get();

        $borrowers = Borrower::all();
        $title = 'Tambah Peminjaman';

        return view('add_borrowings', compact('items', 'borrowers', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_barang' => 'required|exists:barang,id',
            'id_peminjam' => 'required|exists:peminjam,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date|after_or_equal:tanggal_pinjam',
        ]);

        Borrowing::create([
            'id_barang' => $request->id_barang,
            'id_peminjam' => $request->id_peminjam,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
        ]);

        return redirect()->route('borrowings.index')->with('success', 'Peminjaman berhasil ditambahkan!');
    }
}
