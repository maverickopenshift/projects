<?php

namespace Modules\Documents\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Modules\Documents\Entities\DocType;
use Modules\Documents\Entities\DocTemplate;
use Modules\Users\Entities\Pegawai;

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
    public function child()
    {
        return $this->hasMany('Modules\Documents\Entities\Documents','doc_parent_id','id');
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
    public static function check_kontrak($val){
      $count = self::where('id','=',$val)->count();
      if($count>0){
        return true;
      }
      return false;
    }
    public static function get_loker($doc_id){
      $doc = self::select('doc_pihak1_nama')->where('id','=',$doc_id)->first();
      $peg = Pegawai::select('c_kode_unit')->where('n_nik','=',$doc->doc_pihak1_nama)->first();
      return $peg->c_kode_unit;
    }
    public static function create_no_kontrak($template_id,$doc_id,$year=null){
      $loker = self::get_loker($doc_id);
      $start = '00001';
      $pattern = 'K.TEL.';
      $year = (is_null($year))?date('Y'):$year;
      $doc_template = \DB::table('doc_template')->where('id',$template_id)->first();
      $no_kontrak=$pattern.$start.'/'.$doc_template->kode.'/'.$loker."/".$year;
      $count = \DB::table('documents')->where('doc_no', 'like', $pattern.$start.'%')->count();
        if($count==0){
          $new_id = $no_kontrak;
        }
        else{
          //jika 001 sudah ada
          $dt = \DB::table('documents')
                  ->select('doc_no')
                  ->whereNotNull('doc_no')
                  ->orderBy('updated_at','DESC')
                  ->first();

          $last = $dt->doc_no;
          $lastplg = substr($last, 6,5);
          $nextplg = intval($lastplg) + 1;
          $idnya = sprintf('%05s', $nextplg);
          $new_id=$pattern.$idnya.'/'.$doc_template->kode.'/'.$loker."/".$year;
        }
        $count = \DB::table('documents')->where('doc_no',$new_id)->count();
        if($count>1){
          $new_id = self::create_no_kontrak($template_id,$year);
        }
        return $new_id;
    }
    public function get_child($type,$doc_id,$count=true){
      $type = DocType::where('name',$type)->first();
      $temp = DocTemplate::where('id_doc_type', $type->id)->first();
      $doc  = self::where('doc_parent', 0)->where('doc_parent_id', $doc_id)->where('doc_template_id', $temp->id);
      if($count){
        return $doc->count();
      }
      return $doc->get();
    }
    public function total_child($doc_id,$status_no){
      $doc  = self::
      leftJoin('documents as child','child.doc_parent_id','=','documents.id')
      ->leftJoin('documents as child2','child2.doc_parent_id','=','child.id')
          ->where('documents.doc_parent', 0)
          ->where('documents.doc_parent_id', $doc_id)
          ->whereRaw('(child.`doc_signing`='.$status_no.' OR child2.`doc_signing`='.$status_no.' OR documents.`doc_signing`='.$status_no.')')
          ->count();
//      echo $status_no;exit;
      return $doc;
    }
    public static function get_id_parent_sp($doc_id){
      $doc = self::where('doc_parent_id','=',$doc_id)
              ->where('doc_type','=','amandemen_kontrak')
              ->orderBy('doc_title','desc')->first();
      if($doc){
        return $doc->id;
      }
      else{
        return $doc_id;
      }
    }
}
