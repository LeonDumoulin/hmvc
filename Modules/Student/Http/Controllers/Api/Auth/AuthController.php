<?php

namespace Modules\Student\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Student\Http\Requests\LoginRequest;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;
use Modules\Student\Http\Resources\StudentResource;
use Modules\Student\Entities\Student;
use Modules\User\Entities\User;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Hash;
use Modules\Student\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    use ResponseTrait;

    public function login(LoginRequest $request)
    {
        $user = Student::where('email',$request->email)->first();

        if(!$user || !Hash::check($request->password,$user->password)){
            return $this->error('بيانات اﻹعتماد غير متطابقة مع البيانات المسجلة لدينا',404);
        }

        $data['user'] = new StudentResource($user);
        $data['token'] = $user->createToken('student-token')->plainTextToken;

        return $this->success($data,__('auth.success',[],'ar'));
    }

    public function register(RegisterRequest $request)
    {
        $user = Student::create($request->validated());

        $data['user'] =  new StudentResource($user);
        $data['token'] =  $user->createToken('student-token')->plainTextToken;

        return $this->success($data);
    }

    public function logout()
    {
        try{
            auth()->user()->tokens()->delete();
            return $this->success(null,'You are logout successful');
        } catch(\Exception $e){
            return $this->error('',500);
        }

    }
}
