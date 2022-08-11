<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\PaymentMethod;

class PaymentMethodController extends Controller
{

    /**
     * Create a new ColorController instance.
     *
     * @param ColorService $colorService
     */
    public function __construct()
    {
       
    }


    public function index()
    {
      $paymentMethods = PaymentMethod::pluck('description','id')->all();

        return $this->successResponse($paymentMethods);
    }

    
}
