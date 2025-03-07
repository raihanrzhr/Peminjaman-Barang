<?php

namespace App\Models;

use Illuminate\Support\Arr;

class Borrow
{
    public static function all()
    {
        return [
            [
                'id' => 'DO001',
                'nama' => 'John Doe',
                'keterangan' => 'Dosen Informatika'
            ],
            [
                'id' => 'MA002',
                'nama' => 'Tom Cook',
                'keterangan' => 'Mahasiswa Informatika'
            ]
        ];
    }
}