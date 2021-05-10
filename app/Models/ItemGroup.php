<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ItemGroup extends Model
{
    protected $fillable = ['parent_id', 'name', 'description'];
    public function items()
    {
        return $this->hasMany('App\Models\Item');
    }
    public function parent()
    {
    	return $this->belongsTo('App\Models\ItemGroup');
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
