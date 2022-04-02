<?php

namespace Modules\User\Http\Controllers\Dashboard;

use SoulDoit\DataTable\SSP;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\User\Entities\User;
use Response;
use Auth;
use Spatie\Permission\Models\Role;
use DataTables;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public $model;
    public $viewsDomain = 'user::';

    public function __construct()
    {
        $this->model = new User();
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
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->view('index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(User $model)
    {
        $record = new User();
        $roles = Role::pluck('name','id');
        return $this->view('create', compact('record', 'roles'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */

    public function store(Request $request)
    {
        $rules =
            [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed',
                // 'roles.*' => 'required|exists:roles,id',
            ];

        $error_sms =
            [
            //    'name.required' => 'الرجاء ادخال الاسم ',
            //    'email.unique' => ' البريد الالكتروني موجود بالفعل',
            //    'email.required' => 'الرجاء ادخال البريد الالكتروني',
            //    'password.required' => 'الرجاء ادخال كلمة المرور',
            //    'password.confirmed' => 'الرجاء التاكد من كلمة المرور ',

            ];
        $data = validator()->make($request->all(), $rules, $error_sms);

        if ($data->fails()) {
            return back()->withInput()->withErrors($data->errors());
        }
        $user = User::create(request()->all());

        $user->update(['password' => Hash::make($request->password)]);

        // $user->assignRole($request->roles);

        session()->flash('success', __('تم الاضافة بنجاح'));
        return redirect(route('admin.users.index'));
    }
     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        /* $user = User::with('addresses')->findOrFail($id);
         $orders = $user->orders()->latest()->paginate(5);
         return view('admin.sushi.user',compact('user','orders'));*/
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $record = User::findOrFail($id);
        $roles = Role::pluck('name','id');
        return $this->view('edit', compact('record', 'roles'));
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $record = User::findOrFail($id);
        $rules =
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $record->id . '',
                'password' => 'confirmed',
                // 'roles.*' => 'required|exists:roles,id',
            ];
        $error_sms =
            [
            //    'name.required' => 'الرجاء ادخال الاسم ',
            //    'email.required' => 'الرجاء ادخال البريد الالكتروني',
            //    'email.unique' => ' البريد الالكتروني موجود بالفعل',
            //    'password.required' => 'الرجاء ادخال كلمة المرور ',
            //    'password.confirmed' => 'الرجاء التاكد من كلمة المرور ',

            ];
        $data = validator()->make($request->all(), $rules, $error_sms);

        if ($data->fails()) {
            return redirect('/manager/user/' . $id . '/edit')->withInput()->withErrors($data->errors());
        }

        $record->update($request->except('password'));

        if ($request->password) {
            $record->update(['password' => Hash::make($request->password)]);
        }
        if (count((array)$request->roles)) {
            $record->syncRoles($request->roles);
        }

        session()->flash('success', __('تم التعديل بنجاح'));
        return redirect(route('admin.users.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $record = User::findOrFail($id);

        if (auth('web')->user()->id == $record->id) {
            session()->flash('fail', 'This email, you cannot deactivate it');
            return redirect('manager/users');
        }

        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $record->delete();
        $data = [
            'status' => 1,
            'msg' => __('تم الحذف بنجاح'),
            'id' => $id
        ];

        return HttpResponse::json($data, 200);
    }

    public function activation($id)
    {
        $record = User::findOrFail($id);

        if (auth('web')->user()->id == $record->id) {
            session()->flash('error', 'This email, you cannot deactivate it');
            return redirect('manager/user');
        }
        $activate = Helper::activation($record);

        if ($activate) {
            session()->flash('success', 'success');
            return redirect('manager/user');
        }

        session()->flash('fail', 'Something went wrong please try again');
        return redirect('manager/user');
    }








}
