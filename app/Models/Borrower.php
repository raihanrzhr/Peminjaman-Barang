<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrower extends Model
{
    use HasFactory;

    protected $table = 'borrowers';
    protected $primaryKey = 'borrower_id';
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = ['name', 'identifier']; // Tambahkan kolom identifier

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class, 'borrower_id', 'borrower_id');
    }
}