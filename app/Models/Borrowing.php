<?php

namespace App\Models;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Borrowing extends Model
{
    protected $table = 'borrowing';
    protected $primaryKey = 'borrowing_id';
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'activity_id',
        'borrower_id',
        'admin_id',
        'borrowing_proof',
    ];

    public function itemInstances()
    {
        return $this->belongsToMany(ItemInstance::class, 'borrowing_details', 'borrowing_id', 'instance_id');
    }

    public function borrower()
    {
        return $this->belongsTo(Borrower::class, 'borrower_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }

    public function borrowingDetails()
    {
        return $this->hasMany(BorrowingDetails::class, 'borrowing_id');
    }
}