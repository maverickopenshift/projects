<?php

namespace Modules\Documents\Http\Controllers;

use Modules\Documents\Entities\DocType;
use Modules\Documents\Entities\Documents;
use Modules\Documents\Entities\DocBoq;
use Modules\Documents\Entities\DocMeta;
use Modules\Documents\Entities\DocPic;
use Modules\Documents\Entities\DocTemplate;
use App\Helpers\Helpers;
use Validator;
use DB;
use Auth;

class AdendumCreateController
{
  public function __construct()
  {
      //oke
  }
  public function store($request)
  {
    return redirect()->route('doc');
  }
}
