<?php

namespace Modules\Documents\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Documents\Entities\DocType;
use DB;

class DocTemplate extends Model
{
    protected $fillable = [];
    protected $table = 'doc_template';
    
    public static function get_all(){
      $data = DB::table('doc_template as a')
            ->join('doc_category as b', DB::raw( 'b.id' ), '=', DB::raw( 'a.id_doc_category' ))
            ->join('doc_type as c', DB::raw( 'c.id' ), '=', DB::raw( 'a.id_doc_type' ))
            ->selectRaw('ANY_VALUE(a.id) as id,b.`title` as category,c.`title` as type,ANY_VALUE(a.created_at) as created_at')
            ->groupBy(['category','type'])
            ->orderBy('category','desc');
    //  dd($data);
      return $data;
    }
    public static function get_by_type($type){
      $type=DocType::where('name',$type)->first();
      $temp = self::where('id_doc_type', $type->id)->first();
      return $temp;
    }
    public function type()
    {
        return $this->hasOne('Modules\Documents\Entities\DocType','id','id_doc_type');
    }
    public function category()
    {
        return $this->hasOne('Modules\Documents\Entities\DocCategory','id','id_doc_category');
    }
    
    public function detail()
    {
        return $this->belongsTo('Modules\Documents\Entities\DocTemplateDetail','id','id_doc_template');
    }
}
