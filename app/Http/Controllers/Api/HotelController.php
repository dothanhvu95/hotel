<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Utils\Result;
use App\Exceptions\BaseException;
use App\Http\Requests\Api\Home\IndexHomeRequest;
use App\Model\Hotel;

class HotelController extends Controller
{
    
    public function __construct()
    {
        // contruct
    }

    /**
     * function logout
     */

    public function index($id)
    {
        try {

        	$hotel = Hotel::where('id',$id)->first();
        	if(empty($hotel))
        	{
        		return $this->errorResponse(HOTEL_NOT_FIND);
        	}
        	$hotel->load('city','district','ward','images','hotel_detail','hotel_facility');
        	return $this->successResponse($hotel);
            
        } catch (\Throwable $th) {
            throw new BaseException($th->getCode(), $th->getMessage());
        }
    }

    
}
