<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Metadata extends Model
{
    //
    protected $table = 'meta_data';
    protected $fillable = [
        'id_object', 'object_type', 'object_key', 'object_value', 'object_key', 'object_status',
    ];
}
