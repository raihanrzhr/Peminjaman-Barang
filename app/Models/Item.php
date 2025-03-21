<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';
    protected $primaryKey = 'item_id';
    public $timestamps = false; // Nonaktifkan timestamps
    protected $fillable = ['item_name', 'category', 'quantity'];

    public function itemInstances()
    {
        return $this->hasMany(ItemInstance::class, 'item_id', 'item_id');
    }
}