<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Unit extends Model
{
    protected $guarded = [];
    public function stocks()
    {
    	return $this->hasMany('App\Models\Stock');
    }
}
