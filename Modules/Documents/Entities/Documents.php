<?php

namespace Modules\Documents\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Documents extends Model
{
    protected $fillable = [];
    protected $table = 'documents';
    protected static $table2 = 'documents';

    public static function get_fields()
    {
      $field = Schema::getColumnListing(self::$table2);
      $fields = array_flip($field);
      $fields_r = [];
      foreach ($fields as $key => $value) {
        $fields_r[$key] = null;
      }
      return $fields_r;
    }
    public function users(){
      return $this->hasOne('App\User');
    }
    public function jenis(){
      return $this->hasOne('Modules\Documents\Entities\DocTemplate','id','doc_template_id')->with('category','type');
      // return $this->hasManyThrough('Modules\Documents\Entities\DocTemplate', 'Modules\Documents\Entities\DocType');
    }
    public function jenis_category(){
      return $this->hasOne('App\User');
      // return $this->hasManyThrough('Modules\Documents\Entities\DocTemplate', 'Modules\Documents\Entities\DocCategory');
    }
    public function supplier(){
      return $this->hasOne('Modules\Supplier\Entities\Supplier','id','supplier_id');
    }
    public function meta()
    {
        return $this->hasMany('Modules\Documents\Entities\DocMeta');
    }
    public function pic()
    {
        return $this->hasMany('Modules\Documents\Entities\DocPic')->with('pegawai');
    }
    public static function check_po($po){
      $count = \DB::table('dummy_po')->where('no_po','=',$po)->count();
      if($count>0){
        return true;
      }
      return false;
    }
}
