<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Hash;

class ProfileController extends Controller
{
    public function updateProfileView()
    {
        $record = Auth::user();
        return view('admin.auth.update-profile',compact('record'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $this->validate($request, [
            'username' => 'required',
            'email' => ['required','email',Rule::unique('users')->ignore($user->id)],
            'photo' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg',
        ]);

        // if ($request->hasFile('photo')) {
        //     Photo::updatePhoto($request->file('photo'), $user->attachment, $user, 'admins', 'attachment');
        // }

        if ($request->input('old-password')) {
            $this->validate($request, [
                'old-password' => 'required',
                'password' => 'required|confirmed',
            ]);
            if (Hash::check($request->input('old-password'), $user->password)) {
                // The passwords match...
                $user->password = bcrypt($request->input('password'));
                $user->save();
            } else {
                session()->flash('error', 'كلمة المرور غير صحيحة');
                return redirect()->back();
            }
        }

        session()->flash('success', __('تم التعديل بنجاح'));
        return redirect()->back();
    }

    public function updateTheme(Request $request)
    {
        if(auth()->user()->theme == 'dark'){
            auth()->user()->theme = 'light';
            auth()->user()->save();
            return redirect()->back();
        }else{
            auth()->user()->theme = 'dark';
            auth()->user()->save();
            return redirect()->back();
        }
    }
}
