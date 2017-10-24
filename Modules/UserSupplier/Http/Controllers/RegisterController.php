<?php

namespace Modules\UserSupplier\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Supplier\Entities\Supplier;
use App\User;
use App\Role;
// use App\supplier;
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
         $kd_vendor = $this->generate_id();
         $inisial = $request->initial_company_name;
         $bdn_usaha = $request->bdn_usaha;
         $gabung = $bdn_usaha." - ".$inisial;

         $data = new User();
         $data->name = $request->company_name;
         $data->data = $gabung;
         $data->password = bcrypt($request->password);
         $data->phone = $request->phone;
         $data->email = $request->email;
         $data->username = $kd_vendor;
         $data->confirmed = 1;
         $data->actived = 1;
         $data->save ();
         $data->attachRole('vendor');

//EMAIL
        $data2 = array(
          'username'=>$kd_vendor,
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

     private function generate_id(){
       $sup = new Supplier();
       $id = $sup->gen_userid();
       $count=Supplier::where('kd_vendor',$id)->count();
       if($count>0){
         return $this->generate_id();
       }
       else{
         return $id;
       }
     }




}
