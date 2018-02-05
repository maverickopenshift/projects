<?php

namespace Modules\Config\Entities;

use Illuminate\Database\Eloquent\Model;
use DB;

class Config extends Model
{
    protected $fillable = [];
    protected $table = 'config';
    
    public static function get_config($key){
      $config = self::where('object_key','=',$key)->first();
      if($config){
        return $config->object_value;
      }
      return false;
    }
    
    public static function get_penomoran_otomatis($v=null){
      // if(self::get_config('auto-numb')=='off'){
      //   return 'no';
      // }
      // else if(empty($v)){
      //   return 'yes';
      // }
      if(self::get_config('auto-numb')=='off'){
        return 'no';
      }
      return 'yes';
    }
}
