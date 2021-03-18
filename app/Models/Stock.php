<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Stock extends Model
{
    protected $guarded = [];
    public function item()
    {
    	return $this->belongsTo('App\Models\Item');
    }
    public function unit()
    {
    	return $this->belongsTo('App\Model\Unit');
    }
}
