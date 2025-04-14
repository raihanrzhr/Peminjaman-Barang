<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Activity;
use App\Models\Borrower;
use App\Models\Borrowing;
use App\Models\ItemInstance;
use Illuminate\Http\Request;
use App\Models\BorrowingDetails;

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

    public function create()
    {
        $itemInstances = ItemInstance::with('item')->where('status', 'Available')->get();
        $admins = Admin::all(); // Data admin
        return view('add_borrowings', compact('itemInstances', 'admins'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'activity_name' => 'required|string|max:255',
            'activity_date' => 'required|date',
            'borrower_name' => 'required|string|max:255',
            'borrower_identifier' => 'required|string|max:50|unique:borrowers,identifier',
            'admin_id' => 'required|exists:admins,admin_id',
            'item_instances' => 'required|array',
            'borrowing_date' => 'required|date',
            'planned_return_date' => 'required|date|after:borrowing_date',
        ]);

        // Simpan aktivitas ke tabel activities
        $activity = Activity::create([
            'activity_name' => $request->activity_name,
            'activity_date' => $request->activity_date,
        ]);

        // Simpan peminjam ke tabel borrowers
        $borrower = Borrower::create([
            'name' => $request->borrower_name,
            'identifier' => $request->borrower_identifier,
        ]);

        // Simpan data peminjaman ke tabel borrowings
        $borrowing = Borrowing::create([
            'activity_id' => $activity->activity_id,
            'borrower_id' => $borrower->borrower_id,
            'admin_id' => $request->admin_id,
            'borrowing_date' => $request->borrowing_date,
            'planned_return_date' => $request->planned_return_date,
        ]);

        // Simpan item yang dipinjam
        foreach ($request->item_instances as $instance_id) {
            $borrowing->itemInstances()->attach($instance_id);
        }

        return redirect()->route('borrowings.index')->with('success', 'Peminjaman berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $activities = Activity::all();
        $borrowers = Borrower::all();
        $admins = Admin::all();
        $itemInstances = ItemInstance::all();

        return view('edit_borrowing', compact('borrowing', 'activities', 'borrowers', 'admins', 'itemInstances'));
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

    public function update(Request $request, $id)
    {
        $request->validate([
            'activity_id' => 'required|exists:activities,activity_id',
            'borrower_id' => 'required|exists:borrowers,borrower_id',
            'admin_id' => 'required|exists:admin,admin_id',
            'borrowing_date' => 'required|date',
            'planned_return_date' => 'required|date|after_or_equal:borrowing_date',
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
            'planned_return_date' => $request->planned_return_date,
            'return_status' => $request->planned_return_date ? 'Returned' : 'Not Returned',
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

        return redirect()->route('borrowings.index')->with('success', 'Peminjaman berhasil diupdate!');
    }

    public function destroy($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $borrowing->delete();

        return redirect()->route('borrowings.index')->with('success', 'Peminjaman berhasil dihapus!');
    }
}
