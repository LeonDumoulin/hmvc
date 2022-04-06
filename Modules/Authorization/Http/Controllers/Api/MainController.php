<?php

namespace Modules\Authorization\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\User\Entities\User;
use Helper\DataTable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MainController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $records = DB::table('roles')
        // // ->leftJoin('role_has_permissions','role_has_permissions.role_id','=','roles.id')
        // // ->leftJoin('roles','roles.id','=','model_has_roles.role_id')
        // // ->selectRaw('users.id as id , users.name as name , users.email as email , roles.name as role_name')
        // // ->orderBy('roles.id','ASC')
        // ->get()
        // ->toArray();

        $records = Role::with('permissions')->get()->toArray();
        $records = json_encode($records);

        $api = new DataTable($records);
        $data = $api->init();
        // $api->arraySearch($records,$keyword);
        return $data;
    }
}
