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
    public $timestamps = false;
    protected $casts = [
        'borrowing_date' => 'date:Y-m-d',
        'planned_return_date' => 'date:Y-m-d',
        'return_date' => 'date:Y-m-d',
    ];

    protected $fillable = [
        'activity_id',
        'borrower_id',
        'admin_id',
        'borrowing_date',
        'planned_return_date',
        'return_date',
        'return_status',
    ];

    public function itemInstances()
    {
        return $this->belongsToMany(ItemInstance::class, 'borrowing_details', 'borrowing_id', 'instance_id')
                    ->withPivot('quantity', 'proof_file');
    }

    public function borrower()
    {
        return $this->belongsTo(Borrower::class, 'borrower_id', 'borrower_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'admin_id');
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id', 'activity_id');
    }

    public static function getBorrowings()
    {
        $borrowings = DB::table('borrowing as b')
            ->join('borrowers as br', 'b.borrower_id', '=', 'br.borrower_id')
            ->join('admin as a', 'b.admin_id', '=', 'a.admin_id')
            ->join('activities as act', 'b.activity_id', '=', 'act.activity_id')
            ->select('b.borrowing_id', 'b.activity_id', 'b.borrower_id', 'b.admin_id', 'b.borrowing_date', 'b.planned_return_date', 'b.return_date',
                DB::raw("CASE 
                            WHEN b.return_date IS NULL THEN 'Not Returned'
                            ELSE 'Returned'
                        END as return_status"),
                'br.name as borrower_name', 'a.admin_name', 'act.activity_name')
            ->orderBy('b.borrowing_id', 'desc')
            ->get();

        return $borrowings;
    }
}