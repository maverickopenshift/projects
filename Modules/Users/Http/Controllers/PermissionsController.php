<?php

namespace Modules\Users\Http\Controllers;

use Modules\Users\Http\DataTables\PermissionsDataTable;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{
    public function index(PermissionsDataTable $dataTable)
    {
        $data['page_title'] = 'Permissions';
        return $dataTable->render('users::permissions.index',$data);
    }
}
