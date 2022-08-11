<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Utils\Result;
use App\Exceptions\BaseException;
use App\Http\Requests\Api\Booking\BookingRequest;
use Illuminate\Support\Facades\DB;
use App\Model\Hotel;
use App\Model\Booking;
use App\Model\BookingTime;
use Carbon\Carbon;

class BookingController extends Controller
{
    
    public function __construct()
    {
        // contruct
    }

    /**
     * function logout
     */

    public function booking(BookingRequest $request)
    {
        try {
            $user = auth()->user();


            $to = Carbon::createFromFormat('Y-m-d', $request->check_in);
            $from = Carbon::createFromFormat('Y-m-d', $request->check_out);
            $totalDays = $to->diffInDays($from);

        	$hotel = Hotel::find($request->hotel_id);
            if(!empty($hotel) && $hotel->status !== 1)
            {
                return $this->errorResponse(1001,'Hotel do not active');
            }

            $booking = Booking::where('user_id',$user->id)
                        ->where('hotel_id',$request->hotel_id)
                        ->where('status',1) 
                        ->where('check_in',$request->check_in)
                        ->orWhere('check_out',$request->check_out)->first();
            if(!empty($booking))
            {
                return $this->errorResponse(1000,'you have been booking hotel this');
            }
            $result = [];
            DB::transaction(function () use ($request, $user, $hotel, $to, $from, $totalDays, &$result) {
                $createBooking = Booking::create([
                    'user_id' => $user->id,
                    'hotel_id' => $request->hotel_id,
                    'payment_id' => $request->payment_id,
                    'booking_code' => hash('crc32b', microtime()),
                    'guest' => $request->guest,
                    'check_in' => $to,
                    'check_out' => $from,
                    'number_day' => $totalDays,
                    'price' => $hotel->price,
                ]);

                
                BookingTime::create([
                    'user_id' => $user->id,
                    'hotel_id' => $request->hotel_id,
                    'booking_id' => $createBooking->id,
                    'check_in' => $to,
                    'check_out' => $from
                ]);
                $result = $createBooking;
            });

            return $this->successResponse($result);
        } catch (\Throwable $th) {
            throw new BaseException($th->getCode(), $th->getMessage());
        }
    }
}
