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
    public $timestamps = true;
    protected $fillable = [
        'name',
        'nip_nopeg_nim',
        'description',
    ];

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class, 'borrower_id');
    }
}