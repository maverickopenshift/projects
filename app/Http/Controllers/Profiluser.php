<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Validator;
use Response;

class Profiluser extends Controller
{
  public function index()
  {
    $id_session=auth()->user()->id;

      $tbUser = User::where('id','=',$id_session)->first();
      if(!$tbUser){
        abort(404);
      }
      $data['data'] = $tbUser;
      $data['page_title'] = 'User Profile';
      return view('profile')->with($data);
  }

  public function update(Request $request)
  {
    $rules = array (
        'email'                 => 'required|email',
        // 'phone'                 => 'required|regex:/[0-9]/',
        // 'new_password'          => 'min:6',
        // 'password_confirmation' => 'min:6|same:new_password',
    );
    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails ())
        return Response::json (array(
            'errors' => $validator->getMessageBag()->toArray()
        ));
    else {
      $data = User::where('id','=',$request->id)->first();
      $data->email = $request->email;
      $data->phone = $request->phone;
      $data->password = bcrypt($request->new_password);
      $data->save();
      return redirect()->back()->withData($data)->with('message', 'Data berhasil disimpan!');
    }
  }
}
