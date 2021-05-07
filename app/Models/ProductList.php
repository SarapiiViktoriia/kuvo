<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ProductList extends Model
{
    protected $fillable = [
    	'item_id',
    	'count',
    	'quantifiable_type',
    	'quantifiable_id'
    ];
    public function item()
    {
    	return $this->belongsTo('App\Models\Item');
    }
    public function quantifiable()
    {
    	return $this->morphTo();
    }
}
