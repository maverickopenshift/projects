<?php

namespace Modules\Documents\Entities;

use Illuminate\Database\Eloquent\Model;
use DB;

class DocTemplateDetail extends Model
{
    protected $fillable = [];
    protected $table = 'doc_template_detail';
    
    public function category()
    {
        return $this->hasOne('Modules\Documents\Entities\DocCategory','id','id_doc_category');
    }
    public function type()
    {
        return $this->hasOne('Modules\Documents\Entities\DocType','id','id_doc_type');
    }
}
