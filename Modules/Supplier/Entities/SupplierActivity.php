<?php

namespace Modules\Supplier\Entities;

use Illuminate\Database\Eloquent\Model;

class SupplierActivity extends Model
{
    protected $fillable = [];
    public $timestamps = false;
    protected $table = 'supplier_activity';

    public function user()
    {
        return $this->hasOne('App\User','id','users_id');
    }
    // public function document()
    // {
    //     return $this->hasOne('Modules\Users\Entities\Documents','id','documents_id');
    // }
}