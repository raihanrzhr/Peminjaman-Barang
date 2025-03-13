<?php

namespace App\Models;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Borrowing extends Model
{
    protected $table = 'peminjaman';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = false; // Menonaktifkan timestamps
    protected $casts = [
        'tanggal_kembali' => 'date:Y-m-d',
    ];

    protected $fillable = [
        'id_barang',
        'id_peminjam',
        'tanggal_pinjam',
        'tanggal_kembali',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'id_barang', 'id');
    }

    public function borrower()
    {
        return $this->belongsTo(Borrower::class, 'id_peminjam', 'id');
    }

    public static function getBorrowings()
    {
        $borrowings = DB::table('peminjaman as p')
            ->join('barang as b', 'p.id_barang', '=', 'b.id')
            ->join('peminjam as pj', 'p.id_peminjam', '=', 'pj.id')
            ->select('p.id', 'p.id_barang', 'p.id_peminjam', 'p.tanggal_pinjam', 'p.tanggal_kembali',
                DB::raw("CASE 
                            WHEN p.tanggal_kembali IS NULL THEN 'Dipinjam'
                            ELSE 'Dikembalikan'
                        END as status_peminjaman"),
                'b.nama_barang', 'pj.nama as nama_peminjam')
            ->orderBy('p.id', 'desc')
            ->get();

        return $borrowings; // Mengembalikan data peminjaman yang sudah di-join
    }
}