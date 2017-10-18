<?php

namespace Modules\UserSupplier\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\User;
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
       }

        //  Mail::send('usersupplier.notifemail', ['username' => $request->username], function($message)
        //  {
        //    $message->to('$request->email','$request->nm_vendor')->subject('Welcome!');
        //  });
         return response()->json($data);
     }




}
