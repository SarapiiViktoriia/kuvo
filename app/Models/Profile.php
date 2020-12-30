<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
class Profile extends Model
{
	use HasRoles;
	protected $guard_name = 'web';
    protected $guarded = [];
    public function user(){
    	return $this->hasOne('App\User');
    }
}
