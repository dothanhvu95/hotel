<?php

namespace App\Http\Requests\Api\Booking;

use App\Http\Requests\BaseRequest;

class BookingRequest extends BaseRequest
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

            'guest' => 'required|numeric',
            'check_in' => 'required|date|after_or_equal:'.date('Y-m-d'),
            'check_out' => 'required|date|after:check_in',
            'hotel_id' => 'required|numeric|exists:hotels,id',
            'payment_id' =>  'required|numeric|exists:payment_methods,id'
        ];
    }
}