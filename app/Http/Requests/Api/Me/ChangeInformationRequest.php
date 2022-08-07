<?php

namespace App\Http\Requests\Api\Me;

use App\Http\Requests\BaseRequest;

class ChangeInformationRequest extends BaseRequest
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

            'name' => 'nullable|string|string|between:5,255',
            'nickname'=> 'nullable|string|string|between:5,255',
            'phone' =>  'nullable|regex:/^([0-9]*)$/|between:6,14',
            'birthday' => 'nullable|date',
            'gender' => 'nullable|in:1,2',
            
        ];
    }
}