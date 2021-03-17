<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class CapitalPrice extends Model
{
    protected $guarded = [];
    public function item()
    {
    	return $this->belongsTo('App\Models\Item');
    }
}
