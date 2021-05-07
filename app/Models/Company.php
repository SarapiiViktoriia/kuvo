<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Company extends Model
{
    protected $guarded = [];
    public function items()
    {
        return $this->hasMany('App\Models\Item');
    }
}
