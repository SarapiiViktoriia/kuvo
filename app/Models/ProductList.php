<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ProductList extends Model
{
    public function quantifiable()
    {
        $this->morphTo();
    }
    public function item()
    {
        return $this->belongsTo('App\Models\Item');
    }
}
