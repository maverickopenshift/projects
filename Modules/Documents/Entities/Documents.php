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
    
    public static function check_po($po){
      $count = \DB::table('dummy_po')->where('no_po','=',$po)->count();
      if($count>0){
        return true;
      }
      return false;
    }
}
