<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\BaseRequest;

class RegisterRequest extends BaseRequest
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
            'name' => 'required|string|string|between:5,255',
            'email' => 'required|string|email|between:5,255|unique:users',
            'nickname'=> 'required|string|string|between:5,255',
            'phone' =>  'required|regex:/^([0-9]*)$/|between:6,14|unique:users',
            'birthday' => 'required|date',
            'gender' => 'required|in:1,2',
            'password' => 'required|string|between:8,25|confirmed',
            'password_confirmation' => 'required|string|between:8,25'
        ];
    }
}