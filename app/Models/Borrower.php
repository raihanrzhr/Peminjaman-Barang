<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrower extends Model
{
    protected $table = 'borrowers';
    protected $primaryKey = 'borrower_id';
    protected $keyType = 'int';
    public $timestamps = false;

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class, 'borrower_id', 'borrower_id');
    }
}