<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function index()
    {
        return view('admin.auth.login');
    }  

    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|exists:users,email',
            'password' => 'required'
        ];

        $message = [
            'email.required' => 'اسم المستخدم مطلوب',
            'email.exists' => 'هذا المستخدم غير مسجل في قواعد البيانات',
            'password.required' => 'كلمة المرور مطلوبة'
        ];
    
        $data = validator()->make($request->all(), $rules, $message);


        if ($data->fails()) {
            return back()->withInput()->withErrors($data->errors());
        } else {
            $remember = $request->input('remember') && $request->remember == 1 ? $request->remember : 0;

            if (auth()->guard('web')->attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
                return redirect(route('admin.dashboard'));
            } else {
                return back()->withInput()->withErrors(['password' => 'كلمة المرور غير صحيحة']);
            }
        }

        // $credentials = $request->only('email', 'password');

        // if (Auth::attempt($credentials)) {
        //     return redirect(route('admin.dashboard'))->withSuccess('Signed in');
        // }
        // if
        // return redirect(route('admin.login.view'))->withSuccess('Login details are not valid');




        // if ($data->fails()) {
        //     return back()->withInput()->withErrors($data->errors());
        // } else {
        //     $remember = $request->input('remember') && $request->remember == 1 ? $request->remember : 0;

        //     if (auth()->guard('markter')->attempt(['username' => $request->username, 'password' => $request->password], $remember)) {
        //         return redirect(route('index'));
        //     } else {
        //         return back()->withInput()->withErrors(['username' => 'خطأ في البريد الإلكتروني أو كلمة المرور']);
        //     }
        // }
    }

    public function logout(Request $request) {

        Auth::guard('web')->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return Redirect(route('admin.login.view'));


        // Session::flush();
        // Auth::logout();
  
        // return Redirect('login');
    }
}