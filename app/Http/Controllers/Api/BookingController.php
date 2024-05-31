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
                throw new BaseException(1001,'Hotel do not active');
            }

            $countBooking = 0;
            // $booking = Booking::where('hotel_id',$request->hotel_id)
            //         ->where('status',1) 
            //         ->where('check_in',$request->check_in)
            //         ->orWhere('check_out',$request->check_out)
            //         ->get();

            $countBooking = $booking->count();

            if(!empty($hotel) && (int)$countBooking >= (int)$hotel->stock)
            {
                throw new BaseException(1000,'you have been booking hotel this');
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

    public function bookingDetail($id)
    {
        try {
            $user = auth()->user();

            $booking = Booking::with('hotel','hotel.images','hotel.city','hotel.district','hotel.ward','user:id,name,phone')->find($id); 

            if (empty($booking)) {
                throw new BaseException(1005,'Booking detail not exist!');
            }

            if (!empty($booking) && $user->id !== $booking->user_id) {
                throw new BaseException(1009,'Booking not of you');
            }
            return $this->successResponse($booking);
            
        } catch (\Throwable $th) {
            throw new BaseException($th->getCode(), $th->getMessage());
        }
    }

    public function bookingCancel($id)
    {
         try {
            $user = auth()->user();

            $booking = Booking::find($id); 

            if (empty($booking)) {
                throw new BaseException(1005,'Booking detail not exist!');
            }

            if (!empty($booking) && $user->id !== $booking->user_id) {
                throw new BaseException(1009,'Booking not of you');
            }

            switch ($booking->status) {
                case 1:
                    $now = Carbon::now();
                    $curentlyDay = $now->format('Y-m-d');
                    
                    $checkIn = strtotime('-1day',strtotime($booking->check_in));
                    $checkInSub = date('Y-m-d',$checkIn);
                    if (strtotime($curentlyDay) >= strtotime($checkInSub)) {
                        throw new BaseException('2005', 'You can not cancel the booking . because your reservation is tomorrow ');
                    }
                    $booking->status = 3;
                    $booking->save();
                    break;
                
                default:
                    throw new BaseException(2000, 'You can not canceled booking. Because booking in status approved or canceled');
                    break;
            }
            
            return $this->successResponse($booking->fresh());
            
        } catch (\Throwable $th) {
            throw new BaseException($th->getCode(), $th->getMessage());
        }
    }
    public function myBooking(Request $request)
    {
        try {
            $user = auth()->user();

            $perPage = $request->get('count', 5);
            $end_time = $request->end_time;


            $result = [];
            $cursors = [];
            $totals = [];
            $bookings = Booking::with('hotel','hotel.images','hotel.city','hotel.district','hotel.ward')
                
                ->when($request->status, function ($query, $status) {
                    switch ($status) {
                        case 1:
                           return $query->where('status', 1); 
                        case 2:
                           return $query->where('status', 2); 
                        case 3:
                           return $query->where('status', 3);
                        default:
                            return $query; //all status
                    }
                })
                ->orderBy('id','desc')
                ->take($perPage + 1)
                ->get();


        if (count($bookings) > $perPage) {
            $bookings->pop();
            $cursors['after'] = $bookings->last()->id;
        }

        if (isset($cursors['after'])) {
            $result['cursors'] = $cursors;
        }
        $result['bookings'] = $bookings;

        return $this->successResponse($result);
        } catch (\Throwable $th) {
            throw new BaseException($th->getCode(), $th->getMessage());
        }
    }
}
