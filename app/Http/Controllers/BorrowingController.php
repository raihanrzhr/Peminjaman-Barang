<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\BorrowingDetails;
use App\Models\Activity;
use App\Models\ItemInstance;
use App\Models\Borrower;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::with(['activity', 'borrower', 'admin', 'itemInstances'])->get();
        $activities = Activity::all();
        $borrowers = Borrower::all();
        $itemInstances = ItemInstance::all();
        $title = 'Tabel Peminjaman';
        return view('borrowings', compact('borrowings', 'activities', 'borrowers', 'itemInstances', 'title'));
    }

    public function updateStatus(Request $request, $id)
    {
        \Log::info('Update status called', ['id' => $id, 'status' => $request->status]);

        $borrowing = Borrowing::find($id);
        if (!$borrowing) {
            return response()->json(['success' => false, 'message' => 'Peminjaman tidak ditemukan'], 404);
        }

        if ($request->status === 'Dikembalikan') {
            $borrowing->return_date = now(); // Atur tanggal kembali ke waktu sekarang
        } else {
            $borrowing->return_date = null; // Set tanggal kembali menjadi NULL
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
        $itemInstances = ItemInstance::where('status', 'Available')->get();
        $borrowers = Borrower::all();
        $activities = Activity::all();
        $title = 'Tambah Peminjaman';

        return view('add_borrowings', compact('itemInstances', 'borrowers', 'activities', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'activity_id' => 'required|exists:activities,activity_id',
            'borrower_id' => 'required|exists:borrowers,borrower_id',
            'admin_id' => 'required|exists:admin,admin_id',
            'borrowing_date' => 'required|date',
            'return_date' => 'nullable|date|after_or_equal:borrowing_date',
            'item_instances' => 'required|array',
            'item_instances.*.instance_id' => 'required|exists:item_instances,instance_id',
            'item_instances.*.quantity' => 'required|integer|min:1',
        ]);

        $borrowing = Borrowing::create([
            'activity_id' => $request->activity_id,
            'borrower_id' => $request->borrower_id,
            'admin_id' => $request->admin_id,
            'borrowing_date' => $request->borrowing_date,
            'return_date' => $request->return_date,
            'return_status' => 'Not Returned',
        ]);

        foreach ($request->item_instances as $instance) {
            BorrowingDetails::create([
                'borrowing_id' => $borrowing->borrowing_id,
                'instance_id' => $instance['instance_id'],
                'quantity' => $instance['quantity'],
                'proof_file' => $instance['proof_file'] ?? null,
            ]);
        }

        return redirect()->route('borrowings.index')->with('success', 'Peminjaman berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $borrowing = Borrowing::with('itemInstances')->findOrFail($id);
        $activities = Activity::all();
        $borrowers = Borrower::all();
        $itemInstances = ItemInstance::all();
        $title = 'Edit Peminjaman';
        return view('edit_borrowing', compact('borrowing', 'activities', 'borrowers', 'itemInstances', 'title'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'activity_id' => 'required|exists:activities,activity_id',
            'borrower_id' => 'required|exists:borrowers,borrower_id',
            'admin_id' => 'required|exists:admin,admin_id',
            'borrowing_date' => 'required|date',
            'return_date' => 'nullable|date|after_or_equal:borrowing_date',
            'item_instances' => 'required|array',
            'item_instances.*.instance_id' => 'required|exists:item_instances,instance_id',
            'item_instances.*.quantity' => 'required|integer|min:1',
        ]);

        $borrowing = Borrowing::findOrFail($id);
        $borrowing->update([
            'activity_id' => $request->activity_id,
            'borrower_id' => $request->borrower_id,
            'admin_id' => $request->admin_id,
            'borrowing_date' => $request->borrowing_date,
            'return_date' => $request->return_date,
            'return_status' => $request->return_date ? 'Returned' : 'Not Returned',
        ]);

        BorrowingDetails::where('borrowing_id', $id)->delete();
        foreach ($request->item_instances as $instance) {
            BorrowingDetails::create([
                'borrowing_id' => $borrowing->borrowing_id,
                'instance_id' => $instance['instance_id'],
                'quantity' => $instance['quantity'],
                'proof_file' => $instance['proof_file'] ?? null,
            ]);
        }

        return redirect()->route('borrowings.index')->with('success', 'Peminjaman berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $borrowing->delete();

        return redirect()->route('borrowings.index')->with('success', 'Peminjaman berhasil dihapus!');
    }
}
