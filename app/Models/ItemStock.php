<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ItemStock extends Model
{
    protected $guarded = [];
    public function item()
    {
    	return $this->belongsTo('App\Models\Item');
    }
    public function inventoryUnit()
    {
    	return $this->belongsTo('App\Models\InventoryUnit');
    }
}
