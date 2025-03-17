<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'activities';
    protected $primaryKey = 'activity_id';
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'activity_name',
        'activity_date',
        'description',
    ];

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class, 'activity_id', 'activity_id');
    }
}
