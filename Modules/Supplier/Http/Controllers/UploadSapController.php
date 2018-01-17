<?php

namespace Modules\Supplier\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Helpers\Helpers;
use App\Helpers\CustomErrors;
use Modules\Supplier\Entities\SupplierSap as Sap;
use Excel;
use DB;
use Auth;
use Validator;
use Response;

class UploadSapController extends Controller
{
  public function store(Request $request)
  {
    if ($request->ajax()) {
        $data = Excel::load($request->file('supplier_sap')->getRealPath(), function ($reader) {

        })->get();
        $header = ['cl','vendor','cty','name_1','city','postalcode','rg','searchterm','street','date','title','created_by','group','language','vat_registration_no'];
        $colomn = $data->first()->keys()->toArray();

        if(!empty($data) && count($colomn) == 15){
          foreach ($data as $key => $value) {
            $tgl = date_create($value->date);
            $date = date_format($tgl,"Y/m/d");

            $insert[] = ['users_id' => Auth::id(),
                         'ci' => $value->cl,
                         'vendor' => $value->vendor,
                         'cty' => $value->cty,
                         'name_1' => $value->name_1,
                         'city' => $value->city,
                         'postalcode' => $value->postalcode,
                         'rg' => $value->rg,
                         'searchterm' => $value->searchterm,
                         'street' => $value->street,
                         'title' => $value->title,
                         'date' => $date,
                         'created_by' => $value->created_by,
                         'group' => $value->group,
                         'language' => $value->language,
                         'vat_registration_no' => $value->vat_registration_no,
                         'upload_date' => new \DateTime(),
                         'upload_by' => Auth::user()->username,
                       ];
          }
          if(!empty($insert)){
            DB::table('supplier_sap')->insert($insert);
            // $request->session()->flash('alert-success', 'Data berhasil disimsssssan');
            return Response::json(['status'=>true,'csrf_token'=>csrf_token()]);
          }
          else{
            return Response::json(['status'=>false]);
          }
      }
      else{
        return Response::json(['status'=>false]);
      }
    }
    else{
      return Response::json(['status'=>false]);
    }
}

  public function importExcel(Request $request)
      {
          if($request->hasFile('import_file')){
              Excel::load($request->file('import_file')->getRealPath(), function ($reader) {
                  foreach ($reader->toArray() as $key => $row) {
                      $data['title'] = $row['title'];
                      $data['description'] = $row['description'];

                      if(!empty($data)) {
                          DB::table('post')->insert($data);
                      }
                  }
              });
          }

          Session::put('success', 'Youe file successfully import in database!!!');

          return back();
      }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('supplier::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('supplier::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */


    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('supplier::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('supplier::edit');
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
