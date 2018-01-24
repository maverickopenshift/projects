<?php

namespace Modules\Config\Entities;

use Illuminate\Database\Eloquent\Model;
use DB;

class Config extends Model
{
    protected $fillable = [];
    protected $table = 'config';
}
