<?php

namespace App\Models;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;

class Borrower extends Model
{
    protected $table = 'peminjam';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['nama', 'keterangan'];
    // public static function all()
    // {
    //     return [
    //         [
    //             'id' => 'DO001',
    //             'nama' => 'John Doe',
    //             'keterangan' => 'Dosen Informatika'
    //         ],
    //         [
    //             'id' => 'MA002',
    //             'nama' => 'Tom Cook',
    //             'keterangan' => 'Mahasiswa Informatika'
    //         ]
    //     ];
    // }
}