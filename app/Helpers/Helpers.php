<?php
namespace App\Helpers;
use Modules\Documents\Entities\DocCategory;
use Modules\Documents\Entities\DocType;
use Modules\Supplier\Entities\BadanUsaha;
use App\Role;

class Helpers
{

    public static function select_ubis($name='ubis',$val=null)
    {
      $ubis = Role::whereNotIn('name', ['admin','super_admin','vendor'])->get();
      $select  = '<select class="form-control" id="'.$name.'" name="'.$name.'" required>';
      $select .= '<option value="">Pilih UBIS/AP</option>';
      foreach ($ubis as $dt) {
        $selected = '';
        if($val==$dt['id']){
          $selected = 'selected="selected"';
        }
        $select .= '<option value="'.$dt['name'].'" '.$selected.'>'.$dt['display_name'].'</option>';
      }
      $select .= '</select>';
      return $select;
    }
    public static function select_unit($name,$val=null)
    {
      $unit = \App\User::get_unit_by_disivi()->orderBy('title')->get();
      $select  = '<select class="form-control" id="'.$name.'" name="'.$name.'">';
      $select .= '<option value="">Pilih Unit</option>';
      foreach ($unit as $dt) {
        $selected = '';
        if($val==$dt->id){
          $selected = 'selected="selected"';
        }
        $select .= '<option value="'.$dt->id.'" '.$selected.'>'.$dt->title.'</option>';
      }
      $select .= '</select>';
      return $select;
    }
    public static function select_divisi($name,$val=null)
    {
      $unit = \App\User::get_unit_by_disivi()->get();
      $select  = '<select class="form-control" id="'.$name.'" name="'.$name.'">';
      $select .= '<option value="">Pilih Unit</option>';
      foreach ($unit as $dt) {
        $selected = '';
        if($val==$dt->id){
          $selected = 'selected="selected"';
        }
        $select .= '<option value="'.$dt->id.'" '.$selected.'>'.$dt->title.'</option>';
      }
      $select .= '</select>';
      return $select;
    }
    public static function select_category($name='category',$val=null)
    {
      $cat = DocCategory::all();
      $select  = '<select class="form-control" id="'.$name.'" name="'.$name.'" required>';
      $select .= '<option value="">Pilih Jenis Template</option>';
      foreach ($cat as $dt) {
        $selected = '';
        if($val==$dt['id']){
          $selected = 'selected="selected"';
        }
        $select .= '<option value="'.$dt['name'].'" '.$selected.'>'.$dt['title'].'</option>';
      }
      $select .= '</select>';
      return $select;
  }
  public static function select_posisi($val=null){
    return '<select class="form-control pic-posisi" name="pic_posisi[]">
                  <option value="" '.($val==null || $val==""?"selected=\"selected\"":'').'>Pilih Posisi</option>
                  <option value="USER" '.($val=='USER'?"selected=\"selected\"":'').'>USER</option>
                  <option value="WASLAK" '.($val=='WASLAK'?"selected=\"selected\"":'').'>WASLAK</option>
                  <option value="WASPANG" '.($val=='WASPANG'?"selected=\"selected\"":'').'>WASPANG</option>
                  <option value="VENDOR" '.($val=='VENDOR'?"selected=\"selected\"":'').'>VENDOR</option>
                </select>';
  }
  public static function select_jenis($type,$val=null,$name='jenis_kontrak')
  {
    $cat = \DB::table('doc_template')
            ->join('doc_type', 'doc_type.id', '=', 'doc_template.id_doc_type')
            ->join('doc_category', 'doc_category.id', '=', 'doc_template.id_doc_category')
            ->select('doc_template.id','doc_category.title')
            ->where('doc_type.name','=',$type)->get();
    $select  = '<select class="form-control" id="'.$name.'" name="'.$name.'">';
    $select .= '<option value="">Pilih Jenis Kontrak</option>';
    foreach ($cat as $dt) {
      $selected = '';
      if($val==$dt->id){
        $selected = 'selected="selected"';
      }
      $select .= '<option value="'.$dt->id.'" '.$selected.'>'.$dt->title.'</option>';
    }
    $select .= '</select>';
    return $select;
}
public static function select_atasan_by_id($id,$val=null)
{
  $cat = \DB::table('users_atasan')
          ->join('users_pegawai', 'users_pegawai.id', '=', 'users_atasan.users_pegawai_id')
          ->join('pegawai', 'pegawai.n_nik', '=', 'users_atasan.nik')
          ->where('users_pegawai.users_id',$id);
  if($cat->count()==0){
    $us = \App\User::get_pegawai_by_id($id);
    $cat = \App\User::get_atasan_by_divisi($us->objiddivisi,$us->v_band_posisi);
  }
  else{
    $cat = $cat->get();
  }
  $select  = '<select class="form-control" id="doc_pihak1_nama" name="doc_pihak1_nama">';
  $select .= '<option value="">Pilih Penandatangan Pihak 1</option>';
  foreach ($cat as $dt) {
    $selected = '';
    if($val==$dt->n_nik){
      $selected = 'selected="selected"';
    }
    $select .= '<option value="'.$dt->n_nik.'" '.$selected.'>'.$dt->v_nama_karyawan.' - '.$dt->v_short_posisi.'</option>';
  }
  $select .= '</select>';
  return $select;
}
public static function get_approver_by_id($id)
{
  $cat = \DB::table('users_atasan')
          ->join('users_pegawai', 'users_pegawai.id', '=', 'users_atasan.users_pegawai_id')
          ->select('pegawai.v_short_posisi')
          ->join('pegawai', 'pegawai.n_nik', '=', 'users_atasan.nik')
          ->where('users_pegawai.users_id',$id);
  $cat = $cat->get();
  $data = [];
  foreach ($cat as $dt) {
    $data[] = $dt->v_short_posisi;
  }
  return implode(',',$data);
}

public static function get_pihak1_by_id($id)
{
  $cat = \DB::table('users_atasan')
          ->join('users_pegawai', 'users_pegawai.id', '=', 'users_atasan.users_pegawai_id')
          ->selectRaw('pegawai.n_nik,pegawai.v_nama_karyawan,pegawai.v_short_posisi')
          ->join('pegawai', 'pegawai.n_nik', '=', 'users_atasan.nik')
          ->where('users_pegawai.users_id',$id);
  $cat = $cat->get();
  return $cat;
}
public static function get_approver($pegawai)
{
  $cat = \DB::table('users_atasan')
          ->join('users_pegawai', 'users_pegawai.id', '=', 'users_atasan.users_pegawai_id')
          ->join('pegawai', 'pegawai.n_nik', '=', 'users_atasan.nik')
          ->where('users_pegawai.users_id',\Auth::id());
  if($cat->count()==0){
    $cat = \App\User::get_atasan_by_divisi($pegawai->objiddivisi,$pegawai->v_band_posisi);
  }
  else{
    $cat = $cat->get();
  }
  $data = [];
  foreach ($cat as $dt) {
    $data[] = $dt->v_short_posisi;
  }
  return implode(',',$data);
}
public static function select_atasan($pegawai,$val=null)
{
  $cat = \DB::table('users_atasan')
          ->join('users_pegawai', 'users_pegawai.id', '=', 'users_atasan.users_pegawai_id')
          ->join('pegawai', 'pegawai.n_nik', '=', 'users_atasan.nik')
          ->where('users_pegawai.users_id',\Auth::id());
  if($cat->count()==0){
    $cat = \App\User::get_atasan_by_divisi($pegawai->objiddivisi,$pegawai->v_band_posisi);
  }
  else{
    $cat = $cat->get();
  }
  $select  = '<select class="form-control" id="doc_pihak1_nama" name="doc_pihak1_nama">';
  $select .= '<option value="">Pilih Penandatangan Pihak 1</option>';
  foreach ($cat as $dt) {
    $selected = '';
    if($val==$dt->n_nik){
      $selected = 'selected="selected"';
    }
    $select .= '<option value="'.$dt->n_nik.'" '.$selected.'>'.$dt->v_nama_karyawan.' - '.$dt->v_short_posisi.'</option>';
  }
  $select .= '</select>';
  return $select;
}
  public static function select_category2($name='category',$val=null)
  {
    $cat = DocCategory::all();
    $select  = '<select class="form-control" id="'.$name.'" name="'.$name.'">';
    $select .= '<option value="">Pilih Jenis Template</option>';
    foreach ($cat as $dt) {
      $selected = '';
      if($val==$dt['id']){
        $selected = 'selected="selected"';
      }
      $select .= '<option value="'.$dt['id'].'" '.$selected.'>'.$dt['title'].'</option>';
    }
    $select .= '</select>';
    return $select;
  }
    public static function select_type($name='type',$val=null)
    {
      $cat = DocType::all();
      $select  = '<select class="form-control" id="'.$name.'" name="'.$name.'">';
      $select .= '<option value="">Pilih Type Template</option>';
      foreach ($cat as $dt) {
        $selected = '';
        if($val==$dt['id']){
          $selected = 'selected="selected"';
        }
        $select .= '<option value="'.$dt['id'].'" '.$selected.'>'.$dt['title'].'</option>';
      }
      $select .= '</select>';
      return $select;
    }
    public static function select_type2($name='doc_type',$val=null)
    {
      $cat = DocType::all();
      $select  = '<select class="form-control" id="'.$name.'" name="'.$name.'">';
      $select .= '<option value="">Semua Jenis Dokumen</option>';
      foreach ($cat as $dt) {
        $selected = '';
        if($val==$dt['name']){
          $selected = 'selected="selected"';
        }
        $select .= '<option value="'.$dt['name'].'" '.$selected.'>'.$dt['title'].'</option>';
      }
      $select .= '</select>';
      return $select;
    }
    public static function select_badan_usaha($val=null,$name='bdn_usaha')
    {
      $ubis = BadanUsaha::get();
      $select  = '<select class="form-control" id="'.$name.'" name="'.$name.'" required>';
      //$select .= '<option value="">Pilih UBIS/AP</option>';
      foreach ($ubis as $dt) {
        $selected = '';
        if($val==$dt['text']){
          $selected = 'selected="selected"';
        }
        $select .= '<option value="'.$dt['text'].'" '.$selected.'>'.$dt['text'].'</option>';
      }
      $select .= '</select>';
      return $select;
    }

    public static function error_submit_supplier(){
      return [
              'nm_vendor.max' => 'Nama Perusahaan maksimal 500 karakter',
              'nm_vendor.min' => 'Nama Perusahaan minimal 3 karakter',
              'nm_vendor.required' => 'Nama Perusahaan harus diisi',
              'nm_vendor.regex' => 'Nama Perusahaan harus huruf dan angka',
              'klasifikasi_usaha.*.required' => 'Klasifikasi usaha harus diisi',
              'klasifikasi_usaha.*.regex' => 'Klasifikasi usaha harus huruf dan angka',

            ];
    }

    public static function prop_exists($obj,$string,$type='string'){
      if(isset($obj->{$string})){
        return $obj->{$string};
      }
      if(isset($obj[$string])){
        return $obj[$string];
      }
      if($type=='array'){
        return [];
      }
      return false;
    }

    public static function set_filename($kd_vendor,$name){
      return $kd_vendor.'_'.str_slug($name).'_'.time().'_'.str_random(5).'.pdf';
    }
    public static function error_help($obj,$val){
      if ($obj->has($val)):
          return '<span class="error help-block">
              <strong>'.$obj->first($val).'</strong>
          </span>';
      endif;
      return false;
    }
    public static function old_prop_each($obj,$val){
      return old($val,self::prop_exists($obj,$val,'array'));
    }
    public static function old_prop($obj,$val){
      return old($val,self::prop_exists($obj,$val));
    }

    public static function old_prop_selected($obj,$key,$val){
      return old($key,self::prop_exists($obj,$key))==$val?"selected='selected'":"";
    }

    public static function prop_selected($val,$string){
      return ($val==$string)?"selected='selected'":"";
    }
    public static function input_rupiah($val){
      if(!empty($val)){
        $rp = preg_replace('/[^,\d]/','',$val);
        $split = @explode(",",$rp);
        if(count($split)==2){
          return $split[0].'.'.$split[1];
        }
        return $rp;
      }
      return $val;
    }
    public static function create_button($title,$val,$type='primary'){
      if($val>0){
        return '
                <button class="btn btn-'.$type.' btn-xs" type="button" style="line-height: 1;min-width: 43px;margin-right: 5px;padding-bottom: 1px;position: relative;text-align: left;padding-right: 20px;">
                  '.$title.' <span class="badge" style="font-size: 10px;padding-left: 5px;line-height: 1;position: absolute;top: 1px;right: 2px;padding: 1px 4px;">'.$val.'</span>
                </button>';
      }
      return false;
    }
    public static function label_status($val=null,$status=null,$message=null){
      if($val==2){
        $ret ='<span class="label label-warning">draft</span>';
      }
      else if($val==1){
        $ret ='<span class="label label-success">selesai</span>';
      }
      else if($val==3){
        $ret ='<span class="label label-danger">return</span>';
      }
      else{
        $ret ='<span class="label label-info">in-progress</span>';
        // if($status==1)//reject
        // {
        //   $ret ='<button type="button" class="btn btn-xs btn-danger btn-reject" data-msg="'.$message.'">reject</button>';
        // }
      }
      return $ret;
    }
    public static function is_json($string,$return_data = false) {
          $data = json_decode($string);
         return (json_last_error() == JSON_ERROR_NONE) ? ($return_data ? $data : true) : false;
    }
    public static function json_input($json,$new_data){
      $response = self::is_json($json);
      if($response){
        $doc_data = json_decode($json,TRUE);
        foreach($doc_data as $key=>$val){
          if(array_key_exists($key,$new_data)){
            $doc_data = $new_data;
          }
          else{
            $doc_data += $new_data;
          }
        }
        // $doc_data = json_encode($doc_data);
        return json_encode($doc_data) ;
      }
      return NULL;
    }
    public static function doc_status($val,$type=false){
      $status_arr = ['proses','selesai','draft','tracking'];
      foreach ($status_arr as $key => $st){
        if($key==$val && $type==false){
          return $st;
        }
        if($st===$val && $type==true){
          return $key;
        }
      }
      return false;
    }
}
