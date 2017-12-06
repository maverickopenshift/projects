<?php

namespace Modules\Documents\Entities;

use Illuminate\Database\Eloquent\Model;

class DocActivity extends Model
{
    protected $fillable = [];
    public $timestamps = false;
    protected $table = 'doc_activity';
}
