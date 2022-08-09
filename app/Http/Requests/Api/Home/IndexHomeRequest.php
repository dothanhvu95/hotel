<?php

namespace App\Http\Requests\Api\Home;

use App\Http\Requests\BaseRequest;

class IndexHomeRequest extends BaseRequest
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

            'name' => 'nullable',
            'is_recommand' => 'nullable',
            'is_popular' => 'nullable',
            'is_trending' => 'nullable',
            'city_id' => 'nullable'
        ];
    }
}