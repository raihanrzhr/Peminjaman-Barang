<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Activity;
use App\Models\Borrower;
use App\Models\Borrowing;
use App\Models\ItemInstance;
use Illuminate\Http\Request;
use App\Models\BorrowingDetails;
use Illuminate\Support\Facades\Storage;

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
        $itemInstances = ItemInstance::with('item')
            ->where('status', 'Available') // Hanya barang yang tersedia
            ->whereDoesntHave('borrowingDetails', function ($query) {
                $query->whereNull('return_date'); // Barang yang belum dikembalikan
            })
            ->get();

        $admins = Admin::where('role', 1)->get(); // Admin dengan role = 1
        $allAdmins = Admin::all(); // Semua admin (role = 0 dan role = 1)

        // Tambahkan $allAdmins ke compact
        return view('add_borrowings', compact('itemInstances', 'admins', 'allAdmins'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'activity_name' => 'required|string|max:255',
            'activity_date' => 'required|date',
            'borrower_status' => 'required|string|in:Mahasiswa,Pegawai Ditmawa',
            'admin_id_all' => 'required_if:borrower_status,Pegawai Ditmawa|exists:admin,admin_id',
            'borrower_name' => 'required_if:borrower_status,Mahasiswa|string|max:255',
            'borrower_identifier' => 'required_if:borrower_status,Mahasiswa|string|max:50',
            'item_instances' => 'required|array',
            'borrowing_date' => 'required|date',
            'planned_return_date' => 'required|date|after:borrowing_date',
            'borrowing_proof' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Tentukan data peminjam berdasarkan status
        if ($request->borrower_status === 'Pegawai Ditmawa') {
            $admin = Admin::findOrFail($request->admin_id_all); // Gunakan admin_id_all
            $borrowerName = $admin->admin_name; // Ambil nama dari tabel admins
            $borrowerIdentifier = $admin->NIP; // Ambil NIP dari tabel admins
        } else {
            $borrowerName = $request->borrower_name; // Ambil dari input form
            $borrowerIdentifier = $request->borrower_identifier; // Ambil dari input form
        }

        // Simpan aktivitas
        $activity = Activity::firstOrCreate(
            [
                'activity_name' => $request->activity_name,
                'activity_date' => $request->activity_date,
            ],
            [
                'description' => $request->description ?? null, // Tambahkan deskripsi jika ada
            ]
        );

        // Simpan peminjam
        $borrower = Borrower::firstOrCreate(
            [
                'name' => $borrowerName,
                'nip_nopeg_nim' => $borrowerIdentifier,
            ]
        );

        if ($request->hasFile('borrowing_proof')) {
            $borrowingProofPath = $request->file('borrowing_proof')->store('borrowing_proofs', 'public');
        } else {
            $borrowingProofPath = null;
        }

        // Simpan data peminjaman
        $borrowing = Borrowing::create([
            'activity_id' => $activity->activity_id,
            'borrower_id' => $borrower->borrower_id,
            'admin_id' => $request->admin_id, // Tetap gunakan admin_id untuk penanggung jawab tim sisfo
            'borrowing_proof' => $borrowingProofPath, // Simpan path gambar
        ]);

        // Simpan detail peminjaman
        foreach ($request->item_instances as $instance_id) {
            BorrowingDetails::create([
                'borrowing_id' => $borrowing->borrowing_id,
                'instance_id' => $instance_id,
                'borrowing_date' => $request->borrowing_date,
                'planned_return_date' => $request->planned_return_date,
            ]);

            // Update status barang menjadi Unavailable
            $itemInstance = ItemInstance::findOrFail($instance_id);
            $itemInstance->update(['status' => 'Unavailable']);
        }

        return redirect()->route('borrowings.index')->with('success', 'Peminjaman berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $borrowing = Borrowing::with(['activity', 'borrower', 'admin', 'itemInstances.item', 'borrowingDetails'])->findOrFail($id);
        $activities = Activity::all();
        $borrowers = Borrower::all();
        $admins = Admin::where('role', 1)->get(); // Admin dengan role = 1
        $allAdmins = Admin::all(); // Semua admin (role = 0 dan role = 1)

        $itemInstances = ItemInstance::with('item')
            ->where(function ($query) use ($id) {
                $query->where('status', 'Available') // Barang yang tersedia
                      ->orWhereHas('borrowingDetails', function ($subQuery) use ($id) {
                          $subQuery->where('borrowing_id', $id) // Barang yang dipinjam oleh peminjaman saat ini
                                   ->whereNull('return_date'); // Barang yang belum dikembalikan
                      });
            })
            ->get();

        return view('edit_borrowing', compact('borrowing', 'activities', 'borrowers', 'admins','allAdmins', 'itemInstances'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Returned,Not Returned',
        ]);

        $borrowingDetails = BorrowingDetails::findOrFail($id);

        if ($request->status === 'Returned') {
            $borrowingDetails->update([
                'return_status' => 'Returned',
                'return_date' => now(),
            ]);

            // Update status barang menjadi Available
            $itemInstance = ItemInstance::findOrFail($borrowingDetails->instance_id);
            $itemInstance->update(['status' => 'Available']);

            // Set notifikasi sukses
            session()->flash('success', 'Status berhasil diperbarui menjadi Dikembalikan.');
        } else {
            $borrowingDetails->update([
                'return_status' => 'Not Returned',
                'return_date' => null,
            ]);

            // Update status barang menjadi Unavailable
            $itemInstance = ItemInstance::findOrFail($borrowingDetails->instance_id);
            $itemInstance->update(['status' => 'Unavailable']);

            // Set notifikasi sukses
            session()->flash('success', 'Status berhasil diperbarui menjadi Dipinjam.');
        }

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'activity_name' => 'required|string|max:255',
            'activity_date' => 'required|date',
            'borrower_name' => 'required|string|max:255',
            'borrower_identifier' => 'required|string|max:50',
            'admin_id' => 'required|exists:admin,admin_id',
            'item_instances' => 'required|array',
            'borrowing_date' => 'required|date',
            'planned_return_date' => 'required|date|after_or_equal:borrowing_date',
        ]);

        // Cari atau buat aktivitas di tabel activities
        $activity = Activity::firstOrCreate(
            [
                'activity_name' => $request->activity_name,
                'activity_date' => $request->activity_date,
            ],
            [
                'description' => $request->description ?? null, // Tambahkan deskripsi jika ada
            ]
        );

        // Cari atau buat peminjam di tabel borrowers
        $borrower = Borrower::firstOrCreate(
            [
                'name' => $request->borrower_name,
                'nip_nopeg_nim' => $request->borrower_identifier,
            ],
            [
                'description' => $request->description ?? null, // Tambahkan deskripsi jika diperlukan
            ]
        );

        // Cari data peminjaman
        $borrowing = Borrowing::findOrFail($id);

        // Update data peminjaman di tabel borrowing
        $borrowing->update([
            'activity_id' => $activity->activity_id,
            'borrower_id' => $borrower->borrower_id,
            'admin_id' => $request->admin_id,
        ]);

        // Hapus detail peminjaman lama
        BorrowingDetails::where('borrowing_id', $id)->delete();

        // Tambahkan detail peminjaman baru
        foreach ($request->item_instances as $instance_id) {
            BorrowingDetails::create([
                'borrowing_id' => $borrowing->borrowing_id,
                'instance_id' => $instance_id,
                'borrowing_date' => $request->borrowing_date,
                'planned_return_date' => $request->planned_return_date,
            ]);

            // Update status barang menjadi Unavailable
            $itemInstance = ItemInstance::findOrFail($instance_id);
            $itemInstance->update(['status' => 'Unavailable']);
        }

        return redirect()->route('borrowings.index')->with('success', 'Peminjaman berhasil diupdate!');
    }

    public function destroy($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $borrowing->delete();

        return true
        // redirect()->route('borrowings.index')->with('success', 'Peminjaman berhasil dihapus!')
        ;
    }

    public function detail($id)
    {
        $borrowing = Borrowing::with(['activity', 'borrower', 'admin'])->findOrFail($id);
        $borrowingDetails = BorrowingDetails::with(['instance.item'])->where('borrowing_id', $id)->get();
        $title = 'Detail Peminjaman';
        return view('borrowing_detail', compact('borrowing', 'borrowingDetails', 'title'));
    }

    public function uploadProof(Request $request, $id, $type)
    {
        $request->validate([
            'proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($type === 'borrowing') {
            // Handle borrowing proof
            $borrowing = Borrowing::findOrFail($id);
            $path = $request->file('proof')->store('borrowing_proofs', 'public');
            $borrowing->borrowing_proof = $path;
            $borrowing->save();
        } elseif ($type === 'return') {
            // Handle return proof
            $borrowingDetail = BorrowingDetails::findOrFail($id);
            $path = $request->file('proof')->store('return_proofs', 'public');
            $borrowingDetail->return_proof = $path;
            $borrowingDetail->save();
        } else {
            return redirect()->back()->withErrors('Tipe bukti tidak valid.');
        }

        return redirect()->back()->with('success', 'Bukti berhasil diunggah.');
    }
}
