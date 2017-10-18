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
         $inisial = $request->nm_vendor_uq;
         $bdn_usaha = $request->bdn_usaha;
         $gabung = $bdn_usaha." - ".$inisial;

         $data = new User();
         $data->name = $request->nm_vendor;
         $data->data = $gabung;
         $data->password = bcrypt($request->password);
         $data->phone = $request->phone;
         $data->email = $request->email;
         $data->username = $request->username;
         $data->save ();

        //  Mail::send('usersupplier.notifemail', ['username' => $request->username], function($message)
        //  {
        //    $message->to('$request->email','$request->nm_vendor')->subject('Welcome!');
        //  });
         return response()->json($data);
     }




}
