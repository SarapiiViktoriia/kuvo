<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ItemBrand extends Model
{
    protected $fillable = ['name', 'description'];
    public function items()
	{
		return $this->hasMany('App\Models\Item');
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
