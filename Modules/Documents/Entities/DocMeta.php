<?php

namespace Modules\Documents\Entities;

use Illuminate\Database\Eloquent\Model;

class DocMeta extends Model
{
    protected $fillable = [];
    public $timestamps = false;
    protected $table = 'doc_meta';
}
