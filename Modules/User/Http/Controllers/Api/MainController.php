<?php

namespace Modules\User\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\User\Entities\User;
use Helper\DataTable;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $records = User::with(['roles'=>function($q)
        // {
        //     $q->with('permissions',function($query)
        //     {
        //         $query->get(['id','name','group']);
        //     })->get(['id','name']);
        // }])->get(['id','name','email'])->toArray();
        // dd($records);


        $records = DB::table('users')
        ->leftJoin('model_has_roles','model_has_roles.model_id','=','users.id')
        ->leftJoin('roles','roles.id','=','model_has_roles.role_id')
        ->selectRaw('users.id as id , users.name as name , users.email as email , roles.name as role_name')
        ->orderBy('users.id','ASC')
        ->get()
        ->toArray();

        $records = json_encode($records);
        $api = new DataTable($records);
        $data = $api->init();
        return $data;
    }
}
