<?php

namespace Modules\Documents\Entities;

use Illuminate\Database\Eloquent\Model;

use SAPNWRFC\Connection as SapConnection;
use SAPNWRFC\Exception as SapException;

class Sap extends Model
{
    protected $fillable = [];
    
    public static function get_po($po){
      try {
          $c = new SapConnection(config('app.sap'));
          $f = $c->getFunction('Z_MM_PRPO');
          $result = $f->invoke([
              'EBELN' => $po
          ]);
          return ['status'=>true,'data'=>$result,'length'=>count($result['POITEM'])];
      } catch(SapException $ex) {
          $msg = 'Exception: ' . $ex->getMessage() . PHP_EOL;
          return ['status'=>false,'data'=>$msg,'length'=>0];
      }
    }
}
