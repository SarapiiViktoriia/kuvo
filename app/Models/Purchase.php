<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Purchase extends Model
{
    protected $fillable = ['supplier_id', 'arrival_date'];
    public function quantities()
    {
        return $this->morphMany('App\Models\ProductList', 'quantifiable');
    }
}
