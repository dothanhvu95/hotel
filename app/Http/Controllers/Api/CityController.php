<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\City;

class CityController extends Controller
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
      $cities = City::pluck('desc','id')->all();

        return $this->successResponse($cities);
    }

    
}
