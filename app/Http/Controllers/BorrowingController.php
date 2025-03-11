<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::getBorrowings();
        return view('borrowings', compact('borrowings'));
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

    public function store(Request $request)
    {
        // Cek apakah barang sudah dipinjam
        $existingBorrowing = Borrowing::where('id_barang', $request->id_barang)
            ->whereNull('tanggal_kembali')
            ->first();

        if ($existingBorrowing) {
            return response()->json(['success' => false, 'message' => 'Barang sudah dipinjam.'], 400);
        }

        // Logika untuk menyimpan peminjaman baru
        // ...
    }
}
