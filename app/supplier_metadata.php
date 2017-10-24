<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class supplier_metadata extends Model
{
  protected $table = 'supplier_metadata';
  protected $filltable=
  ['id','id_object','object_type','object_key','object_value','object_status'];
}
