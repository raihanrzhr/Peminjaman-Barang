<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowingDetails extends Model
{
    use HasFactory;

    protected $table = 'borrowing_details';
    protected $primaryKey = 'detail_id';
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'borrowing_id',
        'instance_id',
        'borrowing_date',
        'planned_return_date',
        'return_date',
        'return_status',
        'borrowing_proof',
        'return_proof',
    ];

    public function borrowing()
    {
        return $this->belongsTo(Borrowing::class, 'borrowing_id');
    }

    public function instance()
    {
        return $this->belongsTo(ItemInstance::class, 'instance_id');
    }
}
