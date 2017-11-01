<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\CustomErrors;
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
    $tipe = $request->tipe;
    if($tipe=="prof"){
    $rules = array (
        'nama_user'             => 'required|min:3|max:100|regex:/^[a-z .\-]+$/i',
        'email'                 => 'required|max:50|min:4|email',
        'phone'                 => 'required|regex:/[0-9]/|digits_between:7,20',
    );

    $validator = Validator::make($request->all(), $rules,CustomErrors::profile_user());
    if ($validator->fails ()){
      return redirect()->back()
                  ->withInput($request->input())
                  ->withErrors($validator);
    }
    else {
      $data = User::where('id','=',$request->id)->first();
      $data->name = $request->nama_user;
      $data->email = $request->email;
      $data->phone = $request->phone;
      $data->save();
      return redirect()->back()->withData($data)->with('message', 'Data berhasil disimpan!');
    }
  }else{
    $rules = array (
        'Password'              => 'required|min:6',
        'new_password'          => 'required|min:6',
        'password_confirmation' => 'required|min:6|same:new_password',
    );

    $validator = Validator::make($request->all(), $rules,CustomErrors::profile_user());
    if ($validator->fails ()){
      return redirect()->back()
                  ->withInput($request->input())
                  ->withErrors($validator);
    }
    else {
      $data = User::where('id','=',$request->id)->first();
      $data->password = bcrypt($request->new_password);
      $data->save();
      return redirect()->back()->withData($data)->with('message', 'Data berhasil disimpan!');
    }
  }

  }
}
