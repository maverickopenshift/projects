<?php

namespace Modules\Documents\Entities;

use Illuminate\Database\Eloquent\Model;

class DocComment extends Model
{
    protected $fillable = [];
    protected $table = 'doc_comment';
    
    public function user()
    {
        return $this->hasOne('App\User','id','users_id');
    }
    public function document()
    {
        return $this->hasOne('Modules\Users\Entities\Documents','id','documents_id');
    }
}
