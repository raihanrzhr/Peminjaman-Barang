<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemInstance extends Model
{
    protected $table = 'item_instances';
    protected $primaryKey = 'instance_id';
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'item_id',
        'specifications',
        'date_added',
        'status',
        'condition_status',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'item_id');
    }

    public function borrowingDetails()
    {
        return $this->hasMany(BorrowingDetails::class, 'instance_id', 'instance_id');
    }
}
