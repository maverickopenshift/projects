<?php

namespace Modules\Documents\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use Illuminate\Routing\Controller;
use Modules\Documents\Entities\DocComment as Comments;
use Validator;

class DocCommentController extends Controller
{
  public function comments(Request $request)
  {
      $dt = Comments::where('documents_id',$request->id)->with('user')->get();
      
      return Response::json([
        'status' => true,
        'length' => count($dt),
        'data' => $dt,
      ]);
  }
  
  public function edit(Request $request)
  {
        $rules = array (
            'text' => 'required|unique:badan_usaha,text,'.$request->id.'|min:2',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails ())
            return Response::json (array(
                'errors' => $validator->getMessageBag()->toArray()
            ));
        else {
            $data = Comment::where('id','=',$request->id)->first();
            $data->text = $request->text;
            $data->save();
            return response()->json($data);
        }
  }
  public function add(Request $request)
  {
      $rules = array (
          'content' => 'required|min:1|regex:/^[a-z0-9 .\-\,\_\'\&\%\!\?\"\:\+\(\)\@\#\/]+$/i',
      );
      $validator = Validator::make($request->all(), $rules);
      if ($validator->fails ())
          return Response::json (array(
              'errors' => $validator->getMessageBag()->toArray()
          ));
      else {
          $data = new Comments();
          $data->content = $request->content;
          $data->documents_id = $request->id;
          $data->users_id = \Auth::id();
          $data->save ();
          $dt = Comments::where('id',$data->id)->with('user')->first();
          return response()->json($dt);
      }
  }
  public function delete(Request $request)
  {
        $data = Comments::where('id','=',$request->id);
        if(!\Laratrust::hasRole('admin')){
          $data->where('users_id','=',\Auth::id());
        }
        $data->delete();
        return response()->json($data);
  }
}
