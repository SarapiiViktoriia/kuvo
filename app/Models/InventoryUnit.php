<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class InventoryUnit extends Model
{
    protected $fillable = ['name', 'description'];
    public function itemBundlings()
	{
		return $this->hasMany('App\Models\ItemBundling');
	}
	public function itemStocks()
	{
		return $this->hasMany('App\Models\ItemStock');
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
