<?php

namespace App\Http\Requests\Api\Me;

use App\Http\Requests\BaseRequest;

class ChangePasswordRequest extends BaseRequest
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

            'email' => 'required|string|email|between:5,255',
            'password' => 'required|string|between:8,25|confirmed',
            'password_confirmation' => 'required|string|between:8,25'
        ];
    }
}