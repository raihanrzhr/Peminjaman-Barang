<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrower extends Model
{
    protected $table = 'peminjam';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = false;

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class, 'id_peminjam', 'id');
    }
}