<?php

namespace Modules\Logs\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Helper\DataTable;
use OwenIt\Auditing\Models\Audit;

class MainController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $records = Audit::select('id','user_type','user_id','event','created_at')->get()->toArray();
        $records = json_encode($records);

        $api = new DataTable($records);
        $data = $api->init();
        return $data;
    }
}
