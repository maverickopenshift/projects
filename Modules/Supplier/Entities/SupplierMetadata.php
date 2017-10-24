<?php

namespace Modules\Supplier\Entities;

use Illuminate\Database\Eloquent\Model;
use DB;

class SupplierMetadata extends Model
{
    protected $fillable = [];
    protected $table = 'supplier_metadata';
    
    public static function count_meta($id,$key)
    {
        return DB::table('supplier_metadata')->where([
          ['id_object','=',$id],
          ['object_key','=',$key]
          ])->count();
    }
}
