<?php

namespace Modules\User\Http\Controllers\Dashboard;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\User\Entities\User;
use Response;
use Hash;
use Auth;
use Spatie\Permission\Models\Role;

class ChatController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $records = User::where(function ($q) use ($request) {
            if ($request->id) {
                $q->where('id', $request->id);
            } else {
                if ($request->name) {
                    $q->where(function ($q) use ($request) {
                        $q->where('name', 'LIKE', '%' . $request->name . '%')
                           ->orWhere('email', 'LIKE', '%' . $request->name . '%');
                    });
                }
                if ($request->role_name) {
                    $q->whereHas('roles', function ($q) use ($request) {
                        $q->where('display_name', 'LIKE', '%' . $request->role_name . '%');
                    });
                }

                if ($request->from) {
                    $q->whereDate('created_at', '>=', Helper::convertDateTime($request->from));
                }

                if ($request->to) {
                    $q->whereDate('created_at', '<=', Helper::convertDateTime($request->to));
                }
            }
        })->paginate(10);
        return $this->view('index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(User $model)
    {
        $record = new User();
        $roles = Role::all();
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
        return redirect(route('users.index'));
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
        $roles = Role::all();
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

        // if (count((array)$request->roles)) {
        //     $record->syncRoles($request->roles);
        // }

        session()->flash('success', __('تم التعديل بنجاح'));
        return redirect(route('users.index'));
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

        return Response::json($data, 200);
    }

    public function activation($id)
    {
        $record = User::findOrFail($id);

        if (auth('web')->user()->id == $record->id) {
            session()->flash('fail', 'This email, you cannot deactivate it');
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

    public function getUsers(Request $request)
    {
        $data = User::all();
        return response()->json(['data' => $data]);

    }
}
