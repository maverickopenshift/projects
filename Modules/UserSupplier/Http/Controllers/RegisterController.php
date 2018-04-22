<?php

namespace Modules\UserSupplier\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Supplier\Entities\Supplier;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Log;
// use App\supplier;

use App\Mail\SendEmail;
use App\Mail\ResetPwd;
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
         if ($validator->fails ()){
           return redirect()->back()
                       ->withInput($request->input())
                       ->withErrors($validator);
         }
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

            $nama_perusahaan = $request->company_name;
            $sendTo = $request->input('email');
            $subject = 'Konfirmasi Pendaftaran Mitra Telkom';
            $mail_message = $kd_vendor;
            /*
            Log::info('Start');
            Mail::to($sendTo)
                ->queue(new SendEmail($mail_message, $nama_perusahaan, $sendTo, $subject));
            log::info('End');
            */
       }
         return redirect()->back()->withData($data)->with('message', 'Data berhasil disimpan!');
     }

     private function generate_id(){
       $sup = new Supplier();
       $id = $sup->gen_userid();
       $count=User::where('username',$id)->count();
       if($count>0){
         return $this->generate_id();
       }
       else{
         return $id;
       }
     }

     public function forgetpwd()
     {
         return view('usersupplier::lupaPwd');
     }

     public function checking(Request $request)
     {

         $rules = array (
             'email'                => 'required|email',
         );
         $validator = Validator::make($request->all(), $rules);
         if ($validator->fails ()){
           return redirect()->back()
                       ->withInput($request->input())
                       ->withErrors($validator);
         }
         else {
           $email = $request->email;
           $user = User::where('email', $email)->first();
           if(!$user){
             $login_status = false;
             $msg = 'Email Tidak Terdaftar!';
           }else{
             $id = $user->id;
             $nama_perusahaan = $user->name;
             $random_pwd = str_random(8);
//update_Password
             $user->password = bcrypt($random_pwd);
             $user->save();
//Send Email Password
             $sendTo = $email;
             $subject = 'Reset Password';
             // $mail_message = $kd_vendor;

             Log::info('Start');
             Mail::to($sendTo)
                 ->queue(new ResetPwd($random_pwd, $nama_perusahaan, $sendTo, $subject));
             log::info('End');
             $login_status = true;
             $msg = 'Password telah dikirim ke email!';
           }
         }
         return response()->json([
           'status'=>$login_status,
           'msg' => $msg
         ]);
       }



}
