<?php

namespace App\Http\Api\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestController extends Controller
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
       $result = ['a','b','c'];

        return $this->successResponse($result);
    }

    
}
