<?php

namespace Modules\Documents\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Documents\Entities\DocTemplate;
use Modules\Documents\Entities\DocTemplateDetail;
use Datatables;
use Validator;
use Response;

class DocTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data['page_title'] = 'Template Kontrak';
        return view('documents::doc-template.index')->with($data);
    }
    public function data()
    {
        $sql = DocTemplate::with('type','category')->get();
        //dd($sql);
        return Datatables::of($sql)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
              $act= '<div class="btn-group">';
              if(\Auth::user()->hasPermission('ubah-template-pasal-pasal')){
                  $act .='<a href="'.route('doc.template.edit',['id'=>$data->id]).'" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
              }
              if(\Auth::user()->hasPermission('hapus-template-pasal-pasal')){
                $act .='<button type="button" class="btn btn-danger btn-xs" data-id="'.$data->id.'" data-toggle="modal" data-target="#modal-delete"><i class="glyphicon glyphicon-trash"></i> Delete</button>';
              }
              return $act.'</div>';
            })
            ->filterColumn('created_at', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(created_at,'%Y/%m/%d') like ?", ["%$keyword%"]);
            })
            ->editColumn('created_at', function ($data) {
                if($data->created_at){
                    return $data->created_at->format('d-m-Y H:i');
                }
                return '';
            })
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data['page_title'] = 'Tambah Template Kontrak';
        $data['data_action'] = route('doc.template.store');
        $data['data_class'] = 'form-add';
        $data['data'] = [];
        $data['data_detail'] = [];
        return view('documents::doc-template.form')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
      $rules = array (
          'type' => 'required',
          'category' => 'required',
          'pasal.*' => 'required|min:3|max:20',
          'isi.*' => 'required|min:10',
          'judul.*' => 'required|min:5',
      );
      $validator = Validator::make($request->all(), $rules);
      if ($validator->fails ())
          return Response::json (array(
              'errors' => $validator->getMessageBag()->toArray()
          ));
      else {
          $pasal = $request->pasal;
          $isi = $request->isi;
          $judul = $request->judul;
          if(count($pasal)==count($isi) || count($isi)==count($judul) || count($pasal)==count($judul)){
            $cek = DocTemplate::where([
              ['id_doc_type','=',$request->type],
              ['id_doc_category','=',$request->category],
            ])->count();
            if($cek>0){
              return Response::json (array(
                  'errors' => array('error'=>'Jenis dan type template yang Anda masukan sudah ada!')
              ));
            }
            $data = new DocTemplate();
            $data->id_doc_type = $request->type;
            $data->id_doc_category = $request->category;
            $data->kode = $request->kode;
            $data->save ();
            foreach($pasal as $k=>$v){
              $data2 = new DocTemplateDetail();
              $data2->id_doc_template = $data->id;
              $data2->name = $v;
              $data2->title = $judul[$k];
              $data2->desc = $isi[$k];
              $data2->save ();
            }
            return response()->json(array('status'=>true));
          }
          else{
            abort(500);
          }
      }
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit(Request $req)
    {
      $data['page_title'] = 'Ubah Template Kontrak';
      $data['data_action'] = route('doc.template.storeEdit');
      $data['data_class'] = 'form-edit';
      $edit = DocTemplate::where('id','=',$req->id)->with('category','type')->first();
      if(!$edit){
        abort(500);
      }
      $edit_detail = DocTemplateDetail::where('id_doc_template','=',$req->id)->get();
      $data['data'] = $edit;
      $data['data_detail'] = $edit_detail;
      return view('documents::doc-template.form')->with($data);
    }

    public function storeEdit(Request $request)
    {
      $rules = array (
          'type' => 'required',
          'category' => 'required',
          'pasal.*' => 'required|min:3|max:20',
          'isi.*' => 'required|min:10',
          'judul.*' => 'required|min:5',
      );
      $validator = Validator::make($request->all(), $rules);
      if ($validator->fails ())
          return Response::json (array(
              'errors' => $validator->getMessageBag()->toArray()
          ));
      else {
          $id = $request->id;
          $pasal = $request->pasal;
          $isi = $request->isi;
          $judul = $request->judul;
          if(count($pasal)==count($isi) || count($isi)==count($judul) || count($pasal)==count($judul)){

            $data = DocTemplate::where('id','=',$id)->first();
            $data->id_doc_type = $request->type;
            $data->id_doc_category = $request->category;
            $data->kode = $request->kode;
            $data->save ();
            foreach($pasal as $k=>$v){
              $data2 = DocTemplateDetail::where('id_doc_template','=',$id)->first();
              $data2->name = $v;
              $data2->title = $judul[$k];
              $data2->desc = $isi[$k];
              $data2->save ();
            }
            return response()->json(array('status'=>true));
          }
          else{
            abort(500);
          }
      }
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
