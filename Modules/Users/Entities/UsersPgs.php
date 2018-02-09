<?php

namespace Modules\Users\Entities;

use Illuminate\Database\Eloquent\Model;

class UsersPgs extends Model
{
    protected $fillable = [];
    protected $table = 'users_pgs';
    
    public function role(){
      return $this->hasOne('App\Role','id','role_id');
    }
}
