<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ItemBundling extends Model
{
    protected $fillable = ['inventory_unit_id', 'name', 'description'];
    public function inventoryUnit()
    {
    	return $this->belongsTo('App\Models\InventoryUnit');
    }
    public function items()
    {
    	return $this->belongsToMany('App\Models\Item', 'item_has_bundlings');
    }
    public function getDescriptionAttribute($value)
    {
    	if ($value) {
    		return $value;
    	}else{
    		return '-';
    	}
    }
}
