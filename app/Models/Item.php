<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Item extends Model
{
	protected $fillable = ['code', 'name', 'item_brand_id', 'item_group_id', 'image_url', 'description'];
    public function capitalPrices()
    {
        return $this->hasMany('App\Models\CapitalPrice');
    }
	public function itemBrand()
	{
		return $this->belongsTo('App\Models\ItemBrand');
	}
	public function itemGroup()
	{
		return $this->belongsTo('App\Models\ItemGroup');
	}
    public function stocks()
    {
        return $this->hasMany('App\Models\Stock');
    }
    public function supplier()
    {
    	return $this->belongsTo('App\Models\Company');
    }
    public function getDescriptionAttribute($value)
    {
    	if ($value) {
    		return $value;
    	}else{
    		return '-';
    	}
    }
    public function setSkuAttribute($value)
    {
    	$this->attributes['sku'] = strtoupper($value);
    }
}
