<?php

namespace Modules\UserSupplier\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\User;
use Datatables;
use Validator;
use Response;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
      $id_session=auth()->user()->id;

        $tbUser = User::where('id','=',$id_session)->first();
        if(!$tbUser){
          abort(404);
        }
        $data['data'] = $tbUser;
        $data['page_title'] = 'Profile User';
        return view('usersupplier::profile.index')->with($data);
    }

    public function update(Request $request)
    {
              $rules = array (
                  'phone'         => 'required|regex:/[0-9]/',
                  'Password'      => 'required',
                  'new_password'      => 'required|min:6',
                  'password_confirmation' => 'required|min:6|same:new_password',
              );
              $validator = Validator::make($request->all(), $rules);
              if ($validator->fails ())
                  return Response::json (array(
                      'errors' => $validator->getMessageBag()->toArray()
                  ));
              else {
                $data = User::where('id','=',$request->id)->first();
                $data->phone = $request->phone;
                $data->password = bcrypt($request->new_password);
                $data->save();
                return response()->json($data);
              }

    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('usersupplier::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('usersupplier::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('usersupplier::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
