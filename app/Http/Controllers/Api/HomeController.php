<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Utils\Result;
use App\Exceptions\BaseException;
use App\Http\Requests\Api\Home\IndexHomeRequest;
use App\Model\Hotel;

class HomeController extends Controller
{
    
    public function __construct()
    {
        // contruct
    }

    /**
     * function logout
     */

    public function index(IndexHomeRequest $request)
    {
        try {

        	$perPage = $request->get('count', 16);
		    $end_time = $request->end_time;


		    $result = [];
	        $cursors = [];
	        $totals = [];
            $hotels = Hotel::with(['city','district','ward','images'])
	            ->when($request->name, function ($query,$name) {
	                return $query->where('name','LIKE',"%$name%");
	                
				})
    			->when($request->is_recommand, function ($query) {
	                return $query->where('is_recommand',2);
	                
    			})
    			->when($request->is_popular, function ($query) {
	                return $query->where('is_popular',2);
	                
    			})
    			->when($request->is_trending, function ($query) {
	                return $query->where('is_trending',2);
	                
    			})
    			->when($request->city_id, function ($query, $city_id) {
	                return $query->where('city_id',$city_id);
	                
    			})
    			->when($request->after, function ($query, $after) {
	                return $query->where('id', '<', $after);
	            })
    			->where('status', 1)
    			->orderBy('id','desc')
    			->take($perPage + 1)
    			->get();


		if (count($hotels) > $perPage) {
		    $hotels->pop();
		    $cursors['after'] = $hotels->last()->id;
		}

		if (isset($cursors['after'])) {
		    $result['cursors'] = $cursors;
		}
		$result['hotels'] = $hotels;
        return $this->successResponse($result);
            
        } catch (\Throwable $th) {
            throw new BaseException($th->getCode(), $th->getMessage());
        }
    }

    
}
