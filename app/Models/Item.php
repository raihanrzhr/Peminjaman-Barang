<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['nama_barang', 'spesifikasi'];

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class, 'id_barang', 'id');
    }
}