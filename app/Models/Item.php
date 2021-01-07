<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Item extends Model
{
	protected $fillable = ['code', 'name', 'item_brand_id', 'item_group_id', 'image_url', 'description'];
	public function itemBrand()
	{
		return $this->belongsTo('App\Models\ItemBrand');
	}
	public function itemGroup()
	{
		return $this->belongsTo('App\Models\ItemGroup');
	}
    public function suppliers()
    {
    	return $this->belongsToMany('App\Models\Supplier', 'supplier_has_items');
    }
    public function getDescriptionAttribute($value)
    {
    	if ($value) {
    		return $value;
    	}else{
    		return '-';
    	}
    }
    public function setCodeAttribute($value)
    {
    	$this->attributes['code'] = strtoupper($value);
    }
}
