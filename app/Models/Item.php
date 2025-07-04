<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';
    protected $primaryKey = 'item_id';
    public $timestamps = true; // Nonaktifkan timestamps
    protected $fillable = ['category'];

    public function itemInstances()
    {
        return $this->hasMany(ItemInstance::class, 'item_id', 'item_id');
    }
}