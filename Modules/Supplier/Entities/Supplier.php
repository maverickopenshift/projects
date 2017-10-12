<?php

namespace Modules\Supplier\Entities;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [];
    protected $table = 'supplier';

    public function user()
    {
        return $this->hasOne('App\User','id');
    }
}
