<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\BaseRequest;

class SignInRequest extends BaseRequest
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
            'email' => 'required|between:5,255|email',
            'password' => 'required|string|between:8,255',
        ];
    }
}