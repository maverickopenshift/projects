<?php

namespace Modules\Documents\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Modules\Documents\Entities\DocType;
use Modules\Documents\Entities\DocTemplate;
use Modules\Users\Entities\Pegawai;
use Modules\Config\Entities\Config;

use Modules\Documents\Entities\Sap;

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
      return $this->hasOne('App\User','id','user_id');
    }
    public function pegawai(){
      return $this->hasOne('Modules\Users\Entities\Mtzpegawai','n_nik','doc_pihak1_nama');
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
    public function pemilik_kontrak()
    {
        return $this->hasOne('Modules\Documents\Entities\DocMeta')->where('meta_type','pemilik_kontrak');
    }
    public function lampiran_ttd()
    {
        return $this->hasMany('Modules\Documents\Entities\DocMeta')->where('meta_type','lampiran_ttd');
    }
    public function latar_belakang()
    {
        return $this->hasMany('Modules\Documents\Entities\DocMeta')->where('meta_type','latar_belakang');
    }
    public function scope_perubahan()
    {
        return $this->hasMany('Modules\Documents\Entities\DocMeta')->where('meta_type','scope_perubahan');
    }
    public function scope_perubahan_side_letter()
    {
        return $this->hasMany('Modules\Documents\Entities\DocMetaSideLetter');
    }
    public function latar_belakang_surat_pengikatan()
    {
        return $this->hasMany('Modules\Documents\Entities\DocMeta')->where('meta_type','latar_belakang_surat_pengikatan');
    }
    public function latar_belakang_rks()
    {
        return $this->hasMany('Modules\Documents\Entities\DocMeta')->where('meta_type','latar_belakang_rks');
    }
    public function latar_belakang_ketetapan_pemenang()
    {
        return $this->hasMany('Modules\Documents\Entities\DocMeta')->where('meta_type','latar_belakang_ketetapan_pemenang');
    }
    public function latar_belakang_kesanggupan_mitra()
    {
        return $this->hasMany('Modules\Documents\Entities\DocMeta')->where('meta_type','latar_belakang_kesanggupan_mitra');
    }
    public function latar_belakang_optional()
    {
        return $this->hasMany('Modules\Documents\Entities\DocMeta')->where('meta_type','latar_belakang_optional');
    }
    public function latar_belakang_mou()
    {
        return $this->hasMany('Modules\Documents\Entities\DocMeta')->where('meta_type','latar_belakang_mou');
    }
    public function po()
    {
        return $this->hasOne('Modules\Documents\Entities\DocPo');
    }
    public function pasal()
    {
        return $this->hasMany('Modules\Documents\Entities\DocMeta')->where('meta_type','pasal_pasal');
    }
    public function sow_boq()
    {
        return $this->hasMany('Modules\Documents\Entities\DocMeta')->where('meta_type','sow_boq');
    }
    public function asuransi()
    {
        return $this->hasMany('Modules\Documents\Entities\DocAsuransi');
    }
    public function boq()
    {
        return $this->hasMany('Modules\Documents\Entities\DocBoq');
    }
    public function child()
    {
        return $this->hasMany('Modules\Documents\Entities\Documents','doc_parent_id','id');
    }
    public function parent()
    {
        return $this->hasOne('Modules\Documents\Entities\Documents','doc_parent_id','id');
    }
    public function pic()
    {
        return $this->hasMany('Modules\Documents\Entities\DocPic')->with('pegawai');
    }
    public static function check_po($po){
      //$count = \DB::table('dummy_po')->where('no_po','=',$po)->count();
      $sap = Sap::get_po($po);
      if($sap['length']>0){
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
      $peg = \DB::table('__mtz_pegawai')->select('c_kode_unit')->whereNotIn('pegawai_type',['subsidiary'])->where('n_nik','=',$doc->doc_pihak1_nama)->first();
      if(!$peg){
        return null;
      }
      return $peg->c_kode_unit;
    }
    public static function get_loker_by_nik($nik){
      $peg = \DB::table('__mtz_pegawai')->select('c_kode_unit')
                  ->where('n_nik','=',$nik)
                  ->whereNotIn('pegawai_type',['subsidiary'])
                  ->first();
      if(!$peg){
        return null;
      }
      return $peg->c_kode_unit;
    }
    public static function check_no_kontrak($doc_no,$year,$user_type='telkom'){
      $dt = \DB::table('documents');
      if($user_type='telkom'){
        $start = sprintf('%05s', $doc_no);
        $dt = $dt->whereRaw('SUBSTR(doc_no,7,5) = ? ', [$start])
                  ->whereRaw('doc_user_type = ? ', ['telkom'])
                    ->whereRaw('RIGHT(doc_no,4) = ? ', [$year]);
        // $dt = $dt->selectRaw('documents.*,CONVERT(SUBSTR(doc_no,7,5),UNSIGNED INTEGER) as no_urut,RIGHT(doc_no,4) as tahun')
        //           ->whereRaw('CONVERT(SUBSTR(doc_no,7,5),UNSIGNED INTEGER) = ? ', [$doc_no])
        //           ->whereRaw('RIGHT(doc_no,4) = ? ', [date('Y')])
        //           ->whereRaw('doc_user_type = ? ', ['telkom'])
        //           ->whereRaw('doc_no is not null')
        //           ->orderByRaw('id', 'desc');
      }
      else{
        $dt = $dt->whereRaw('doc_no = ? ', [$doc_no])
                 ->whereRaw('doc_user_type = ? ', ['subsidiary'])
                 ->orderBy('id', 'desc');
      }
      return $dt->first();
    }
    public static function create_manual_no_kontrak($doc_no,$nik,$template_id,$date,$doc_type){
      $no = sprintf('%05s', $doc_no);
      $loker = self::get_loker_by_nik($nik);
      $year = date('Y',strtotime($date));
      $doc_template = \DB::table('doc_template')->where('id',$template_id)->first();
      $pattern = ($doc_type=='surat_pengikatan')?'C.TEL.':'K.TEL.';
      $no_kontrak=$pattern.$no.'/'.$doc_template->kode.'/'.$loker."/".$year;
      $count = \DB::table('documents')
                    ->whereRaw('SUBSTR(doc_no,7,5) = ? ', [$no])
                    ->whereRaw('RIGHT(doc_no,4) = ? ', [$year])
                    ->count();
      if($count==0){
        $new_id = $no_kontrak;
      }
      else{
        $doc_no = $doc_no+1;
        $new_id = self::create_manual_no_kontrak($doc_no,$nik,$template_id,$date,$doc_type);
      }
      return $new_id;
    }
    // $dt = $dt->selectRaw('documents.*,CONVERT(SUBSTR(doc_no,7,5),UNSIGNED INTEGER) as no_urut,RIGHT(doc_no,4) as tahun')
    //           ->whereRaw('tahun = ? ', [date('Y')])
    //           ->whereRaw('doc_user_type = ? ', ['telkom'])
    //           ->whereRaw('doc_no is not null')
    //           ->orderBy('id', 'desc')
    public static function create_no_kontrak($template_id,$doc_id,$int=1){
      $loker = self::get_loker($doc_id);
      $doc = \DB::table('documents')->where('id',$doc_id)->first();
      if($doc){
        if($doc->penomoran_otomatis=='yes' && $doc->doc_user_type=='telkom'){
          $start = sprintf('%05s', Config::get_config('start-number'));
          $pattern = ($doc->doc_type=='surat_pengikatan')?'C.TEL.':'K.TEL.';
          $year = date('Y');
          $doc_template = \DB::table('doc_template')->where('id',$template_id)->first();
          $no_kontrak=$pattern.$start.'/'.$doc_template->kode.'/'.$loker."/".$year;
          $count = \DB::table('documents')
                        ->whereRaw('SUBSTR(doc_no,7,5) = ? ', [$start])
                        ->whereRaw('RIGHT(doc_no,4) = ? ', [$year])
                        ->count();
            if($count==0){
              $new_id = $no_kontrak;
            }
            else{
              //jika 001 sudah ada
              $dt = \DB::table('documents')
                      ->select('doc_no')
                      ->whereNotNull('doc_no')
                      ->orderByRaw('CONVERT(SUBSTR(doc_no,7,5),UNSIGNED INTEGER) DESC')
                      ->orderByRaw('RIGHT(doc_no,4) DESC')
                      ->first();
              $last = $dt->doc_no;
              $lastplg = substr($last, 6,5);
              $nextplg = intval($lastplg) + $int;
              $idnya = sprintf('%05s', $nextplg);
              $new_id=$pattern.$idnya.'/'.$doc_template->kode.'/'.$loker."/".$year;
            }
            $count = \DB::table('documents')->where('doc_no',$new_id)->count();
            if($count>1){
              $int = $int+1;
              $new_id = self::create_no_kontrak($template_id,$doc_id,$int);
            }
            return $new_id;
        }
        else{
          return $doc->doc_no;
        }
      }
      return '';
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
    public static function check_permission_doc($doc_id,$type){
      $user_type = \App\User::check_usertype(\Auth::user()->username);
      $doc = self::selectRaw('documents.id,documents.user_id');
      $doc->join('v_users_pegawai','v_users_pegawai.user_id','=','documents.user_id');
      if(!\Laratrust::hasRole('admin')){
        if($user_type=='subsidiary'){
          $doc->where('v_users_pegawai.company_id',\App\User::get_subsidiary_user()->company_id)
          ->where('v_users_pegawai.pegawai_type','subsidiary');
        }else{
          $doc->where('v_users_pegawai.objiddivisi',\App\User::get_divisi_by_user_id());
        }

      }
      $doc->where('documents.id','=',$doc_id);
      if(!empty($type)){
        $doc->where('documents.doc_type',$type);
      }
      $doc = $doc->first();
      if($doc){
        return true;
      }
      return false;
    }
    public static function get_parent_doc($value){
      if($value->doc_parent == 0 && !empty($value->doc_parent_id)){
        $get = Documents::where('id',$value->doc_parent_id)->first();
        return $get;
      }
      return false;
    }
    public static function get_parent_doc_first($value){
      if($value->doc_parent == 0 && !empty($value->doc_parent_id)){
        $get = Documents::where('id',$value->doc_parent_id)->first();
        if($get->doc_parent == 0 && !empty($get->doc_parent_id)){
          return self::get_parent_doc_first($get);
        }
        return $get;
      }
      return false;
    }
    public static function get_parent_title($value){
      $dt = self::get_parent_doc_first($value);
      if($dt){
        return ' - '.$dt->doc_title;
      }
      return '';
    }
}
