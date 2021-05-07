<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Purchase extends Model
{
    protected $fillable = [
    	'supplier_id',
    	'arrival_date'
    ];
    public function purchases()
    {
    	return $this->morphMany('App\Model\ProductList', 'quantifiable');
    }
    public function supplier()
    {
    	return $this->belongsTo('App\Models\Company');
    }
}
