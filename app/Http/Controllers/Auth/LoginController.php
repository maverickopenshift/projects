<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\TelkomLdap;
use Modules\Users\Entities\UsersPgs;
use App\User;
use Response;
use Validator;
use App\Helpers\Helpers;
use DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';
    
    private $server_ldap = "ldap.telkom.co.id";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
         $field = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
         $request->merge([$field => $request->input('login')]);
         if($field == 'username' && config('app.env')=='production'){
           $ldap = new TelkomLdap();
           $server = $this->server_ldap;
           $username = $request->input('login');
           $ldap = $ldap->authenticate($server,$request->input('login'),$request->input('password'));
           if($ldap=='OK'){
             $user = User::where('username',$username)->first();
             if($user){
               if (Auth::loginUsingId($user->id))
               {
                   return redirect('/');
               }
             }
           }
         }
         if (Auth::attempt($request->only($field, 'password')))
         {
             return redirect('/');
         }
     
         return redirect('/login')->withErrors([
             'error' => 'These credentials do not match our records.',
         ]);
     }
     public function loginAjax(Request $request)
     {
          if (!$request->ajax()) {abort(404);};
          
          $login_status = false;
          $msg = 'These credentials do not match our records';
          $pgs = false;
          $pgs_list = [];
          $field = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
          $request->merge([$field => $request->input('login')]);
          if($field == 'username' && config('app.env')=='production'){
            $ldap = new TelkomLdap();
            $server = $this->server_ldap;
            $username = $request->input('login');
            $ldap = $ldap->authenticate($server,$request->input('login'),$request->input('password'));
            if($ldap=='OK'){
              $user = User::where('username',$username)->first();
              if($user){
                if (Auth::loginUsingId($user->id))
                {
                    $login_status = true;
                    $msg = 'Login berhasil';
                }
              }
            }
          }
          if (Auth::attempt($request->only($field, 'password')))
          {
              $login_status = true;
              $msg = 'Login berhasil';
          }
          if($login_status){
            $id = Auth::id();
            $pegawai_hitung = DB::table('v_users_pegawai')->where('user_id',$id)->count();
            if($pegawai_hitung!=0){
              $pegawai = DB::table('v_users_pegawai')->where('user_id',$id)->first();
              $request->session()->put('nik', $pegawai->n_nik);
              $request->session()->put('posisi', $pegawai->v_short_posisi);
            }else{
              $request->session()->put('nik', '');
              $request->session()->put('posisi', '');
            }
            
            

            $user_pgs = UsersPgs::where('users_id',$id)->first();
            if($user_pgs){
              $role_1 = DB::table('roles')->where('id',$user_pgs->role_id)->first();
              $role_2 = DB::table('roles')->where('id',$user_pgs->role_id_first)->first();
              $pgs_list = [
                ['id'=>$role_1->id,'title'=>$role_1->display_name],
                ['id'=>$role_2->id,'title'=>$role_2->display_name],
              ];
              
              $pgs = true;
            }
          }
          return response()->json([
            'status'=>$login_status,
            'msg' => $msg,
            'pgs' => $pgs,
            'pgs_list' => $pgs_list
          ]);
      }
      
      private function check_host(){
        if(gethostbyname($this->server_ldap) == gethostname()){
          return true;
        }
        return false;
      }
}
