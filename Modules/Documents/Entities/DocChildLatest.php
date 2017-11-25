<?php

namespace Modules\Documents\Entities;

use Illuminate\Database\Eloquent\Model;

class DocChildLatest extends Model
{
    protected $fillable = [];
    protected $table = 'doc_child_latest';
    
    public function jenis(){
      return $this->hasOne('Modules\Documents\Entities\DocTemplate','id','doc_template_id')->with('category','type');
      // return $this->hasManyThrough('Modules\Documents\Entities\DocTemplate', 'Modules\Documents\Entities\DocType');
    }
    public function supplier(){
      return $this->hasOne('Modules\Supplier\Entities\Supplier','id','supplier_id');
    }
    public function pic()
    {
        return $this->hasMany('Modules\Documents\Entities\DocPic','documents_id','id')->with('pegawai');
    }
}
