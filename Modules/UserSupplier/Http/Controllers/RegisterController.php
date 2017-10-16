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

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('usersupplier::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
     public function add(Request $request)
     {
       $rules = array (
           'bdn_usaha' => 'required',
           'nm_vendor' => 'required|min:5',
           'nm_vendor_uq' => 'required|max:3|min:3',
           'password' => 'required|min:8',
           'phone' => 'required|max:12',
           'email' => 'required|unique:users,email',
       );
       $validator = Validator::make($request->all(), $rules);
       if ($validator->fails ())
           return Response::json (array(
               'errors' => $validator->getMessageBag()->toArray()
           ));
       else {
             $inisial = $request->nm_vendor_uq;
             $bdn_usaha = $request->bdn_usaha;
             $gabung = $bdn_usaha." - ".$inisial;

             $data = new User();
            //  $data->data = $request->bdn_usaha;
             $data->name = $request->nm_vendor;
             $data->data = $gabung;
             $data->password = $request->password;
             $data->phone = $request->phone;
             $data->email = $request->email;
             $data->save ();
             return view('usersupplier::register');
           }
     }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('usersupplier::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('usersupplier::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
