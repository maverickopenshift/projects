<?php

namespace Modules\Documents\Entities;

use Illuminate\Database\Eloquent\Model;

class DocMeta extends Model
{
    protected $fillable = [];
    public $timestamps = false;
    protected $table = 'doc_meta';
    
    public static function get_first($doc_id,$meta_key){
      return self::where('documents_id',$doc_id)->where('meta_type',$meta_key)->first();
    }
    public static function get_all($doc_id,$meta_key){
      return self::where('documents_id',$doc_id)->where('meta_type',$meta_key)->get();
    }  
}
