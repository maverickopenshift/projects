<?php

namespace Modules\Documents\Entities;

use Illuminate\Database\Eloquent\Model;

class DocMetaSideLetter extends Model
{
    protected $fillable = [];
    public $timestamps = false;
    protected $table = 'doc_meta_side_letter';
}
