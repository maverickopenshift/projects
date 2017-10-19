<?php

namespace Modules\UserSupplier\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\User;
use App\Role;
use Datatables;
use Validator;
use Response;

class DataSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
      $data['page_title'] = 'Data Supplier';
      return view("usersupplier::dataSupplier.index")->with($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
     public function tambah()
     {
         $data['page_title'] = 'Kelengkapan Data Supplier';
         return view('usersupplier::dataSupplier.create')->with($data);
     }

     public function add(Request $request)
     {
         $inisial = $request->initial_company_name;
         $bdn_usaha = $request->bdn_usaha;
         $gabung = $bdn_usaha." - ".$inisial;

         $data = new User();
         $data->name = $request->company_name;
         $data->data = $gabung;
         $data->password = bcrypt($request->password);
         $data->phone = $request->phone;
         $data->email = $request->email;
         $data->username = $request->username;
         $data->save ();


}
