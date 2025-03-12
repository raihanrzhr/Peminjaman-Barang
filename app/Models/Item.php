<?php

namespace App\Models;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['nama_barang', 'spesifikasi'];

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
}