<?php

namespace Modules\UserSupplier\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\User;
use App\supplier;
use Mail;
use Validator;
use Response;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('usersupplier::register');
    }

     public function add(Request $request)
     {
         $rules = array (
             'bdn_usaha'            => 'required',
             'company_name'         => 'required|min:5|unique:users,name',
             'initial_company_name' => 'required|size:3',
             'password'             => 'required|min:6',
             'phone'                => 'required|regex:/[0-9]/',
             'email'                => 'required|email|unique:users,email',
         );
         $validator = Validator::make($request->all(), $rules);
         if ($validator->fails ())
             return Response::json (array(
                 'errors' => $validator->getMessageBag()->toArray()
             ));
         else {
          //  dd($request);
         $inisial = $request->initial_company_name;
         $bdn_usaha = $request->bdn_usaha;
         $gabung = $bdn_usaha." - ".$inisial;

         $data = new User();
         $data->name = $request->company_name;
         $data->data = $gabung;
         $data->password = bcrypt($request->password);
         $data->phone = $request->phone;
         $data->email = $request->email;
         $data->username = $request->username;
         $data->save ();

//SAVE KE SUPPLIER
        $users = \DB::table('users')
        ->select('id')
        ->where('username', '=', $request->username)->first();

        foreach ($users as $key) {
          $data = new supplier();
          $data->id_user = $value;
          $data->kd_vendor = $request->username;
          $data->save ();
        }
//EMAIL
        $data2 = array(
          'username'=>$request->username,
          'email'=>$request->email,
          'nama'=>$request->company_name
        );
        $us=$data2['username'];

        Mail::send('usersupplier::notifEmail', ['data2' => $data2] , function($message) use($data2)
        {


          $message->to($data2['email'], 'Annisa Dwu')->subject('Welcome!');
          $message->from('inartdemo@gmail.com','Do Not Reply');

        });


       }


         return response()->json($data);
     }




}
