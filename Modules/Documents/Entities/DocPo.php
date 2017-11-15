<?php

namespace Modules\Documents\Entities;

use Illuminate\Database\Eloquent\Model;

class DocPo extends Model
{
    protected $fillable = [];
    public $timestamps = false;
    protected $table = 'doc_po';
}
