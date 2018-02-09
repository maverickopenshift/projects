<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Documents\Entities\Documents;

use Response;
use Validator;
use DB;
use Modules\Users\Entities\Pegawai;
use Modules\Users\Entities\UsersPgs;
use Modules\Users\Entities\PegawaiNonorganik;
use App\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(\Laratrust::hasRole('vendor')){
          return view('home');
        }
        $month = ($request->m)?$request->m:date('m');
        $year = ($request->y)?$request->y:date('Y');
        $data['page_title'] = 'Dashboard';
        $data['month'] = $month;
        $data['year'] = $year;
        $data['doc'] = [
          'surat_pengikatan' => self::get_count('surat_pengikatan',$month,$year),
          'khs' => self::get_count('khs',$month,$year),
          'turnkey' => self::get_count('turnkey',$month,$year),
          'sp' => self::get_count('sp',$month,$year),
          'amandemen_sp' => self::get_count('amandemen_sp',$month,$year),
          'amandemen_kontrak' => self::get_count('amandemen_kontrak',$month,$year),
          'addendum' => self::get_count('addendum',$month,$year),
          'side_letter' => self::get_count('side_letter',$month,$year),
          'mou' => self::get_count('mou',$month,$year),
        ];
        return view('home_dashboard')->with($data);
    }
    private function get_count($type,$month,$year){
      return Documents::where('doc_type', $type)
                            ->whereRaw('MONTH(created_at) = '.intval($month))
                            ->whereRaw('YEAR(created_at) = '.intval($year))
                            ->count();
    }
    public function pgs(Request $request)
    {
      $id = Auth::id();
      $data = [];
      $data['page_title'] = 'Dashboard';
      $user = User::where('id',$id)->with('roles')->first();
      $user_type = User::check_usertype($user->username);
      $user_pgs = UsersPgs::where('users_id',$id)->with('role')->get();
      if (!$user_pgs) {abort(404);};
      $data['user_pgs'] = $user_pgs;
      $data['user'] = $user;
      
      // dd($data);
      return view('auth.pgs')->with($data);
    }
    public function pgsChange(Request $request)
    {
         if (!$request->ajax()) {abort(404);};
         $id = Auth::id();
         $user_pgs = UsersPgs::where('users_id',$id)->get();
         if($user_pgs){
           $rules = array (
               'pgs'    => 'required|exists:users_pgs,id',
           );
           $validator = Validator::make($request->all(), $rules);
           if ($validator->fails ()){
             return response()->json(['status'=>false,'msg'=>'PGS yang Anda pilih tidak ditemukan']); 
           }
           foreach ($user_pgs as $pgs){
             $up = UsersPgs::where('id',$pgs->id)->first();
             if($up->id == $request->pgs){
               $up->pgs_status = 'active';
               DB::table('role_user')->where('user_id',$id)->update(['role_id'=>$up->role_id]);
             }
             else{
               $up->pgs_status = 'inactive';
             }
             $up->save();
           }
           return response()->json(['status'=>true,'msg'=>'success']); 
         }
         return response()->json(['status'=>false,'msg'=>'Anda bukan User PGS']); 
         
    }
}
