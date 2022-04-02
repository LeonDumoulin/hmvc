<?php

namespace Modules\Student\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'name'      => 'required',
            'email'     => 'email|unique:students,email',
            'phone'     => 'unique:students,phone',
            'password'  => 'min:6',
            'password_confirmation' => 'required|same:password',
        ];
    }

    /**
     * Return response json if validation failed
     *
     * @return Response
     */
    public function failedValidation(Validator $validator)
    {
    throw new HttpResponseException(response()->json([
        'success'   => false,
        'message'   => 'Validation errors',
        'data'      => $validator->errors()
    ]));
    }

}
