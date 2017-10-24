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
    
    public static function get_legal_dokumen($id){
      return self::select(['id','object_value'])->where([
        ['id_object','=',$id],
        ['object_key','=','legal_dokumen']
      ])->get();
    }
    
    public static function get_sertifikat_dokumen($id){
      return self::select(['id','object_value'])->where([
        ['id_object','=',$id],
        ['object_key','=','sertifikat_dokumen']
      ])->get();
    }
}
