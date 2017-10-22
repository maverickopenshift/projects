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
    public static function select_category($name='category',$val=null)
    {
      $cat = DocCategory::all();
      $select  = '<select class="form-control" id="'.$name.'" name="'.$name.'" required>';
      $select .= '<option value="">Pilih Kategori</option>';
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
}
