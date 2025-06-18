<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'admin_id';
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'admin_name',
        'role', // Tambahkan role
        'NIP', // Tambahkan NIP
    ];

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class, 'admin_id', 'admin_id');
    }
}
