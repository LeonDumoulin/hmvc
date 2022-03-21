<?php

namespace Modules\Authorization\Http\Controllers\Dashboard;

use Helper\Response;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use \Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public $model;
    public $viewsDomain = 'authorization::';

    public function __construct()
    {
        $this->model = new Role();
    }
    /**
     * @param $view
     * @param array $params
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view($view, $params = [])
    {
        return view($this->viewsDomain . $view, $params);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('authorization::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        Artisan::call('permission:cache-reset');
        $model = new Role();
        $permissions = Permission::select('group')->groupBy('group')->get();
        return view('authorization::create',compact('model', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $rules=
        [
            'name'=>'required|unique:roles',
            // 'display_name'=>'required',
            // 'description'=>'required',
            'permissions'=>'required',

        ];

    $message=
        [
            'name.required'=>'الرجاء ادخال الاسم',
            'name.unique'=>'تم ادخال هذه الصلاحية من قبل',
            // 'display_name.required'=>'الرجاء ادخال الاسم المعروض',
            // 'description.required'=>'الرجاء ادخال الوصف',
            'permissions.required'=>'الرجاء ادخال الوصف'

        ];

    $data = validator()->make($request->all(), $rules, $message);
    if ($data->fails()) {
        return back()->withInput()->withErrors($data->errors());
    }

    $record = Role::create(request()->except('permissions', 'sellectAll'));
    $record->permissions()->attach($request->permissions);

    session()->flash('success', __('تم الاضافة بنجاح'));
    return redirect(route('admin.roles.index'));
}

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('authorization::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        Artisan::call('permission:cache-reset');
        $model = Role::findOrFail($id);
        $permissions = Permission::select('group')->groupBy('group')->get();
        return view('authorization::edit',compact('model', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        // if ($id == 1) {
        //     session()->flash('error', __('لا يمكن تعديل صلاحيات الأدمن الرئيسي'));
        //     return redirect(route('admin.roles.index'));
        // }

        $record = Role::findOrFail($id);

        $rules=
            [
                'name'=>'required|unique:roles,name,'.$record->id.'',
//                'display_name'=>'required',
                // 'description'=>'required',
                'permissions'=>'required',

            ];

        $message=
            [
                'name.required'=>'الرجاء ادخال الاسم',
                'name.unique'=>'تم اخال هذه الصلاحية من قبل',
                // 'display_name.required'=>'الرجاء اخال الاسم المعروض',
                // 'description.required'=>'الرجاء اخال الوصف'

            ];
        $data = validator()->make($request->all(), $rules, $message);

        if ($data->fails()) {
            return back()->withInput()->withErrors($data->errors());
        }

        $record ->update($request->except('permissions', 'sellectAll'));
        $record->permissions()->sync($request->permissions);

        session()->flash('success', __('تم التعديل بنجاح'));
        return redirect(route('admin.roles.index'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $record = Role::findOrFail($id);

        $users = $record->users()->get();

        if (!count($users) || $id != 1) {
            $record->permissions()->detach();
            $record->delete();

            $data = [
                'status' => 1,
                'msg' => __('تم الحذف بنجاح'),
                'id' => $id
            ];
            return Response::json($data, 200);
        } else {
            $data = [
                'status' => 0,
                'msg' => ' فشل الحذف , يوجد مستخدمين مرتبطين بهذه الصلاحية',
                'id' => $id
            ];
            return Response::json($data, 200);
        }
    }
}
