<?php

namespace Modules\Documents\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Documents\Entities\Documents;
use Modules\Documents\Entities\DocType;
use Modules\Documents\Entities\DocMeta;
use App\Helpers\Helpers;
use Response;
use Validator;
use Auth;

class DocumentsClosingController extends Controller
{
    protected $documents;

    public function __construct(Documents $documents)
    {
        $this->documents = $documents;
    }

    public function index(Request $request)
    {
      $id = $request->id;
      $doc_type = DocType::where('name','=',$request->type)->first();
      $dt = $this->documents->where('id','=',$id)->first();

      if(!$doc_type || !$dt){
        abort(404);
      }
      if(!$this->documents->check_permission_doc($id,$doc_type->name)){
        abort(404);
      }
      $data['doc_type'] = $doc_type;
      $data['page_title'] = 'Closing - '.$doc_type['title'];
      $data['doc'] = $dt;
      $data['id'] = $id;
      $data['doc_parent'] = \DB::table('documents')->where('id',$dt->doc_parent_id)->first();

        return view('documents::form-closing')->with($data);
    }

    public function get_child($id,$parent_id){
      $result = $this->documents->where('doc_parent_id','=',$parent_id)->get();
      $hasil=array();
      $x=0;

      for($i=0;$i<count($result);$i++){
        if($id!=$result[$i]->id){
          $hasil[$x]=$result[$i]->id;
          $x++;

          $hitung=$this->documents->where('doc_parent_id',$result[$i]->id)->count();
          if($hitung!=0){
            $result_child=$this->get_child($id, $result[$i]->id);
            for($y=0;$y<count($result_child);$y++){
              $hasil[$x]=$result_child[$y];
              $x++;
            }
          }

        }
      }

      return $hasil;
    }

    public function create(Request $request)
    {
      /*
        $id = $request->id;
        $rules = [];
        $rules['gr_nomer.*']    =  'required|max:500|regex:/^[a-z0-9 .\-]+$/i';
        $rules['gr_nilai.*']    =  'required|max:500';

        $rules['bast_judul']   =  'required|max:500|regex:/^[a-z0-9 .\-]+$/i';
        $rules['bast_tgl']     =  'required|date_format:"Y-m-d"';
        $rules['bast_file']    = 'required|mimes:pdf';
        $rules['baut_judul']   =  'required|max:500|regex:/^[a-z0-9 .\-]+$/i';
        $rules['baut_tgl']     =  'required|date_format:"Y-m-d"';
        $rules['baut_file']    = 'required|mimes:pdf';

        $validator = Validator::make($request->all(), $rules,\App\Helpers\CustomErrors::documents());
        if ($validator->fails ()){
          return redirect()->back()->withInput($request->input())->withErrors($validator);
        }else{

          $result=$this->documents->where('id',$id)->get();
          $hasil=array();
          $x=0;
          for($i=0;$i<count($result);$i++){
              $hasil[$x]=$result[$i]->id;
              $x++;
              $hitung=$this->documents->where('doc_parent_id',$result[$i]->id)->count();

              if($hitung!=0){
                $result_child=$this->get_child($id, $result[$i]->id);
                for($y=0;$y<count($result_child);$y++){
                  $hasil[$x]=$result_child[$y];
                  $x++;
                }
              }
          } 

          
          $doc = $this->documents->whereIn('id',$hasil)->first();
          $doc->doc_signing = '4';
          $doc->save();

          if(isset($request->bast_judul)){
            $doc_meta = new DocMeta();
            $doc_meta->documents_id = $id;
            $doc_meta->meta_type = "Lampiran_Bast";
            $doc_meta->meta_name = $request->bast_judul;
            $doc_meta->meta_desc = $request->bast_tgl;

            if(isset($request->bast_file)){
              $fileName   = Helpers::set_filename('doc_lampiran_',strtolower($request->bast_judul));
              $file = $request->bast_file;
              $file->storeAs('document/lampiran_bast', $fileName);
              $doc_meta->meta_file = $fileName;
            }

            $doc_meta->save();
          }

          if(isset($request->baut_judul)){
            $doc_meta = new DocMeta();
            $doc_meta->documents_id = $id;
            $doc_meta->meta_type = "Lampiran_Baut";
            $doc_meta->meta_name = $request->baut_judul;
            $doc_meta->meta_desc = $request->baut_tgl;

            if(isset($request->baut_file)){
              $fileName   = Helpers::set_filename('doc_lampiran_',strtolower($request->baut_judul));
              $file = $request->baut_file;
              $file->storeAs('document/lampiran_baut', $fileName);
              $doc_meta->meta_file = $fileName;
            }

            $doc_meta->save();
          }

          if(count($request->gr_nomer)>0){
            foreach($request->gr_nomer as $key => $val){
              if(!empty($val)
              ){
                $doc_meta2 = new DocMeta();
                $doc_meta2->documents_id = $id;
                $doc_meta2->meta_type = 'GR';
                $doc_meta2->meta_name = $request['gr_nomer'][$key];
                $doc_meta2->meta_desc = $request['gr_nilai'][$key];
                $doc_meta2->save();
              }
            }
          }
          
          $request->session()->flash('alert-success', 'Data berhasil disimpan');
          return redirect()->route('doc',['status'=>'tutup']);
      }
      */
    }
    
    public function store_ajax(Request $request)
    {
      $id = $request->id;
      $rules = [];
      
      $date_format = 'date_format:"d-m-Y"';
      $rules['gr_nomer.*']   = 'required|max:500|regex:/^[a-z0-9 .\-]+$/i';
      $rules['gr_nilai.*']   = 'required|max:500';

      $rules['bast_judul']   = 'required|max:500|regex:/^[a-z0-9 .\-]+$/i';
      $rules['bast_tgl']     = 'required|'.$date_format;
      $rules['bast_file']    = 'required|mimes:pdf';

      $rules['baut_judul']   = 'required|max:500|regex:/^[a-z0-9 .\-]+$/i';
      $rules['baut_tgl']     = 'required|'.$date_format;
      $rules['baut_file']    = 'required|mimes:pdf';      

      foreach($request->lain_judul as $k => $v){
        if($v!=null){
          $rules['lain_judul.*']   = 'max:500|regex:/^[a-z0-9 .\-]+$/i';
          $rules['lain_tanggal.*'] = 'required|'.$date_format;  
          $rules['lain_file.'.$k] = 'required|mimes:pdf';  
        }        
      }

      $validator = Validator::make($request->all(), $rules,\App\Helpers\CustomErrors::documents());
      if ($validator->fails ()){
        //return redirect()->back()->withInput($request->input())->withErrors($validator);
        return Response::json (array(
            'errors' => $validator->getMessageBag()->toArray()
          ));
      }else{
        $result=$this->documents->where('id',$id)->get();
        $hasil=array();
        $x=0;

        for($i=0;$i<count($result);$i++){
          $hasil[$x]=$result[$i]->id;
          $x++;
          $hitung=$this->documents->where('doc_parent_id',$result[$i]->id)->count();

          if($hitung!=0){
            $result_child=$this->get_child($id, $result[$i]->id);
            for($y=0;$y<count($result_child);$y++){
              $hasil[$x]=$result_child[$y];
              $x++;
            }
          }
        }
          
        $doc = $this->documents->whereIn('id',$hasil)->first();
        $doc->doc_signing = '4';
        $doc->save();

        if(isset($request->bast_judul)){
          $doc_meta = new DocMeta();
          $doc_meta->documents_id = $id;
          $doc_meta->meta_type = "Lampiran_Bast";
          $doc_meta->meta_name = $request->bast_judul;
          $doc_meta->meta_desc = Helpers::date_set_db($request->bast_tgl);

          if(isset($request->bast_file)){
            $fileName   = Helpers::set_filename('doc_lampiran_',strtolower($request->bast_judul));
            $file = $request->bast_file;
            $file->storeAs('document/lampiran_bast', $fileName);
            $doc_meta->meta_file = $fileName;
          }

          $doc_meta->save();
        }

        if(isset($request->baut_judul)){
          $doc_meta = new DocMeta();
          $doc_meta->documents_id = $id;
          $doc_meta->meta_type = "Lampiran_Baut";
          $doc_meta->meta_name = $request->baut_judul;
          $doc_meta->meta_desc = Helpers::date_set_db($request->baut_tgl);

          if(isset($request->baut_file)){
            $fileName   = Helpers::set_filename('doc_lampiran_',strtolower($request->baut_judul));
            $file = $request->baut_file;
            $file->storeAs('document/lampiran_baut', $fileName);
            $doc_meta->meta_file = $fileName;
          }

          $doc_meta->save();
        }

        if(count($request->lain_judul)>0){
          foreach($request->lain_judul as $key => $val){
            if(!empty($val) && !empty($request['lain_judul'][$key])){

              $doc_meta = new DocMeta();
              $doc_meta->documents_id = $id;
              $doc_meta->meta_type = "Lampiran_Lain";
              $doc_meta->meta_name = $request['lain_judul'][$key];
              $doc_meta->meta_desc = Helpers::date_set_db($request['lain_tanggal'][$key]);

              if(isset($request['lain_file'][$key])){
                $fileName   = Helpers::set_filename('doc_lampiran_',strtolower($val));
                $file = $request['lain_file'][$key];
                $file->storeAs('document/lampiran_lain', $fileName);
                $doc_meta->meta_file = $fileName;
              }
              $doc_meta->save();
            }
          }
        }

        if(count($request->gr_nomer)>0){
          foreach($request->gr_nomer as $key => $val){
            if(!empty($val)
            ){
              $doc_meta2 = new DocMeta();
              $doc_meta2->documents_id = $id;
              $doc_meta2->meta_type = 'GR';
              $doc_meta2->meta_name = $request['gr_nomer'][$key];
              $doc_meta2->meta_desc = $request['gr_nilai'][$key];
              $doc_meta2->save();
            }
          }
        }

        $request->session()->flash('alert-success', 'Data berhasil disimpan');
        return Response::json (array(
          'status' => 'tutup'
        ));
      }
    }
}
