<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BorrowingDetails extends Model
{
    protected $table = 'borrowing_details';
    protected $primaryKey = 'detail_id';
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'borrowing_id',
        'instance_id',
        'quantity',
        'proof_file',
    ];

    public function borrowing()
    {
        return $this->belongsTo(Borrowing::class, 'borrowing_id', 'borrowing_id');
    }

    public function itemInstance()
    {
        return $this->belongsTo(ItemInstance::class, 'instance_id', 'instance_id');
    }
}
