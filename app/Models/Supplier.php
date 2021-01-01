<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Supplier extends Model
{
	protected $fillable = ['code', 'name'];  
	public function items()
	{
		return $this->belongsToMany('App\Models\Item', 'supplier_has_items');
	}
    public function setCodeAttribute($value)
    {
    	$this->attributes['code'] = strtoupper($value);
    }
}
