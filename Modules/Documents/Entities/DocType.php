<?php

namespace Modules\Documents\Entities;

use Illuminate\Database\Eloquent\Model;

class DocType extends Model
{
    protected $fillable = [];
    protected $table = 'doc_type';

    public static function get_by_key($key){
      return $this->where('name','=',$key)->first();
    }
}
