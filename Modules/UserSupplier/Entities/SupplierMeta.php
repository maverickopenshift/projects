<?php

namespace Modules\UserSupplier\Entities;

use Illuminate\Database\Eloquent\Model;

class SupplierMeta extends Model
{
    protected $fillable = [];
    public $timestamps = false;
    protected $table = 'supplier_meta';

    public static function get_legal_dokumen($id){
      return self::select(['id','meta_file_name','meta_file'])->where([
        ['supplier_id','=',$id],
        ['meta_type','=','legal_dokumen']
      ])->get();
    }

    public static function get_sertifikat_dokumen($id){
      return self::select(['id','meta_name','meta_start_date','meta_end_date','meta_file_name','meta_file'])->where([
        ['supplier_id','=',$id],
        ['meta_type','=','sertifikat_keahlian']
      ])->get();
    }
}
