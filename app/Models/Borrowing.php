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
    // public static function all()
    // {
    //     return [
    //         [
    //             'id' => 'PR001',
    //             'namaBarang' => 'Proyektor',
    //             'spesifikasi' => 'Proyektor Epson EB-X05 memiliki tingkat kecerahan 3.300 lumens dengan resolusi XGA 1024 x 768 piksel. Proyektor ini memiliki kontras 15.000:1 dan teknologi 3LCD yang menghasilkan warna yang lebih cerah dan tajam. Proyektor ini juga memiliki fitur kecerahan warna 3.300 lumens dan kecerahan putih 3.300 lumens.'
    //         ],
    //         [
    //             'id' => 'LP001',
    //             'namaBarang' => 'Laptop',
    //             'spesifikasi' => 'Laptop ASUS VivoBook A412DA merupakan laptop yang memiliki desain yang stylish dan ringan. Laptop ini memiliki layar NanoEdge 14 inci dengan bezel tipis yang membuat tampilan layar lebih luas. Laptop ini juga memiliki prosesor AMD Ryzen 5 3500U dan RAM 8GB DDR4.'
    //         ]
    //     ];  
    // }

//     public static function find($id): array
//    {
//        $item = Arr::first(static::all(), fn ($item) => $item['id'] == $id);
//        return $item ?: []; // Kembalikan array kosong jika tidak ditemukan
//    }

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