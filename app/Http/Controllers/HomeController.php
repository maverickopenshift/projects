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
        //$month = ($request->m)?$request->m:date('m');
        //$year = ($request->y)?$request->y:date('Y');

        $range = ($request->doc_range)?$request->doc_range:'';
        $dari = ($request->doc_daritanggal)?$request->doc_daritanggal:'';
        $sampai = ($request->doc_sampaitanggal)?$request->doc_sampaitanggal:'';

        $newdari = date("d-m-Y", strtotime($dari));
        $newsampai = date("d-m-Y", strtotime($sampai));

        if($dari=='' and $sampai==''){
          if($range!=''){
            $title="Data $range Bulan terakhir";
          }else{
            $title="Data 1 Bulan terakhir";
          }
        }else{
          if($dari!='' and $sampai!=''){
            $title="Data dari $newdari sampai $newsampai";
          }else{
            if($dari!=''){
              $title="Data dari $newdari";
            }
            
            if($sampai!=''){
              $title="Data Sampai $newsampai";
            }
          }
        }       

        $data['page_title'] = 'Dashboard';
        $data['title']=$title;
        $data['month'] = 3;
        $data['year'] = 2018;
        $data['range']=$range;
        $data['dari']=$dari;
        $data['sampai']=$sampai;
        $data['doc'] = [
          'surat_pengikatan' => self::get_count('surat_pengikatan',$range,$dari,$sampai),
          'khs' => self::get_count('khs',$range,$dari,$sampai),
          'turnkey' => self::get_count('turnkey',$range,$dari,$sampai),
          'sp' => self::get_count('sp',$range,$dari,$sampai),
          'amandemen_sp' => self::get_count('amandemen_sp',$range,$dari,$sampai),
          'amandemen_kontrak' => self::get_count('amandemen_kontrak',$range,$dari,$sampai),
          'addendum' => self::get_count('addendum',$range,$dari,$sampai),
          'side_letter' => self::get_count('side_letter',$range,$dari,$sampai),
          'mou' => self::get_count('mou',$range,$dari,$sampai),
        ];

        return view('home_dashboard')->with($data);
    }

    private function get_count($type,$range,$dari,$sampai){
      $documents=Documents::where('doc_type', $type);

      if($dari=='' and $sampai==''){
        if($range!=''){
          $documents->whereRaw("created_at >= last_day(now()) + interval 1 day - interval $range month");
        }else{
          $documents->whereRaw("created_at >= last_day(now()) + interval 1 day - interval 1 month");
        }
      }else{
        if($dari!=''){
          $documents->whereRaw("created_at >= '$dari 00:00:00'");
        }
        
        if($sampai!=''){
          $documents->whereRaw("created_at <= '$sampai 00:00:00'");
        }
      }

      return $documents->count();
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
           Auth::logout();
           if(Auth::loginUsingId($id)){
             return response()->json(['status'=>true,'msg'=>'success']); 
           }
         }
         return response()->json(['status'=>false,'msg'=>'Anda bukan User PGS']); 
         
    }
}
