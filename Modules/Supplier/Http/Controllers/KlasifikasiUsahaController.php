<?php

namespace Modules\Supplier\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Supplier\Entities\KlasifikasiUsaha;
use Datatables;
use Validator;
use Response;

class KlasifikasiUsahaController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data['page_title'] = 'Klasifikasi Usaha';
        return view('supplier::klasifikasi-usaha.index')->with($data);
    }

    public function data(Request $request)
    {
        $sql = KlasifikasiUsaha::get();
        return Datatables::of($sql)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
              $dataAttr = htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');
              $act= '<div class="btn-group">';
              if(\Auth::user()->hasPermission('ubah-klasifikasi-usaha')){
                  $act .='<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#form-modal"  data-title="Edit" data-data="'.$dataAttr.'" data-id="'.$data->id.'"><i class="glyphicon glyphicon-edit"></i> Edit</button>';
              }
              if(\Auth::user()->hasPermission('hapus-klasifikasi-usaha')){
                $act .='<button type="button" class="btn btn-danger btn-xs" data-id="'.$data->id.'" data-toggle="modal" data-target="#modal-delete"><i class="glyphicon glyphicon-trash"></i> Delete</button>';
              }
              return $act.'</div>';
            })
            ->filterColumn('updated_at', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(updated_at,'%Y/%m/%d') like ?", ["%$keyword%"]);
            })
            ->filterColumn('created_at', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(created_at,'%Y/%m/%d') like ?", ["%$keyword%"]);
            })
            ->editColumn('updated_at', function ($data) {
                if($data->updated_at){
                    return $data->updated_at->format('d-m-Y H:i');
                }
                return;
            })
            ->editColumn('created_at', function ($data) {
                if($data->created_at){
                    return $data->created_at->format('d-m-Y H:i');
                }
                return;
            })
            ->make(true);
    }
    public function update(Request $request)
  	{
          $rules = array (
              'kode' => 'required|unique:klasifikasi_usaha,kode,'.$request->id.'|min:3',
              'text' => 'required|unique:klasifikasi_usaha,text,'.$request->id.'|min:3',
          );
          $validator = Validator::make($request->all(), $rules);
          if ($validator->fails ())
              return Response::json (array(
                  'errors' => $validator->getMessageBag()->toArray()
              ));
          else {
              $data = KlasifikasiUsaha::where('id','=',$request->id)->first();
              $data->kode = $request->kode;
              $data->text = $request->text;
              $data->save();
              return response()->json($data);
          }
  	}
    public function add(Request $request)
    {
        $rules = array (
            'kode' => 'required|unique:klasifikasi_usaha,kode|min:3',
            'text' => 'required|unique:klasifikasi_usaha,text|min:3',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails ())
            return Response::json (array(
                'errors' => $validator->getMessageBag()->toArray()
            ));
        else {
            $data = new KlasifikasiUsaha();
            $data->kode = $request->kode;
            $data->text = $request->text;
            $data->save ();
            return response()->json($data);
        }
    }
    public function delete(Request $request)
    {
          $data = KlasifikasiUsaha::where('id','=',$request->id)->delete();
          return response()->json($data);
    }

    // public function getSelect(Request $request){
    //     $search = trim($request->q);
    //
    //     if (empty($search)) {
    //         return \Response::json([]);
    //     }
    //     $data =  KlasifikasiUsaha::select(['text as value','text as data'])->where('text',"like",'%'.$search.'%')->limit(30)->get();
    //     $data = ['suggestions'=>$data];
    //     return \Response::json($data);
    // }

    public function getSelect(Request $request){
        $search = trim($request->q);
        $not_in = $request->notin;

        // if (empty($search)) {
        //     return \Response::json([]);
        // }
        $data = KlasifikasiUsaha::select('id','text','kode');
        if(!empty($search)){
          $data->where(function($q) use ($search) {
              $q->orWhere('text', 'like', '%'.$search.'%');
              $q->orWhere('kode', 'like', '%'.$search.'%');
          });
        }
        if(is_array($not_in)){
          $data->whereNotIn('kode',$not_in);
        }
        $data = $data->paginate(30);
        return \Response::json($data);
    }
}
