<?php

namespace App\Http\Controllers\Api;

use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Booking\BookingCreateRequest;
use App\Http\Requests\Booking\BookingUpdateRequest;
use App\Http\Requests\Booking\CheckAvailabilityRequest;
use App\Http\Resources\Booking\BookingResource;
use App\Services\CheckAvailablity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookingCreateRequest $request) :JsonResponse
    {
        //

        DB::beginTransaction();

        //Did this as a service so we can check availabitity whenever we might need some validation
        $availablity = CheckAvailablity::checkAvailability($request->from_date, $request->to_date);
        
        if($availablity > 0){
            try{
                $booking = Booking::create([
                    'customer_id'      => $request->input('customer_id'),
                    'parking_space_id' => $request->input('parking_space_id'),
                    'car_reg'          => $request->input('car_reg'),
                    'from_date'        => $request->input('from_date'),
                    'to_date'          => $request->input('to_date'),
                ]);

                DB::commit();

                return response()->json([
                    'status'   => true,
                    'message'  => 'Booking Created',
                    'booking'  => $booking
                ], 201);
            }
            catch (\Throwable $th) {

                DB::rollback();

                return response()->json([
                    'status'  => false,
                    'message' => $th->getMessage()
                ], 500);
            }
        }else {
            return response()->json([
                'status'  => true,
                'message' => 'No spaces available for given dates'
            ], 200);
        }
    }

    /**
     * Display the Booking.
     */
    public function show(Booking $booking) :BookingResource
    {
        return new BookingResource($booking);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        //
    }

  /**
     * Update Booking Details.
     *
     * @param BookingUpdateRequest $request
     * @param Booking $booking
     * @return App\Http\Resources\Booking\BookingResource
     */
    public function update(BookingUpdateRequest $request, Booking $booking)
    {
        DB::beginTransaction();

        //Did this as a service so we can check availabitity whenever we might need some validation
        $availablity = CheckAvailablity::checkAvailability($request->from_date, $request->to_date);

        if($availablity > 0){
            try {

                $booking->update([
                    'car_reg'   => $request->input('car_reg'),
                    'from_date' => $request->input('from_date'),
                    'to_date'   => $request->input('to_date'),
                ]);

                DB::commit();

                return new BookingResource($booking->refresh());
            } catch (\Throwable $th) {
                DB::rollback();
                return response()->json([
                    'status'  => false,
                    'message' => $th->getMessage()
                ], 500);
            }
        }else {
            return response()->json([
                'status'  => true,
                'message' => 'No spaces available for given dates'
            ], 200);
        }
    }

    /**
     * Cancel Booking.
     * 
     * @param Booking $booking
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Booking $booking)
    {
        //
        DB::beginTransaction();

        try{
         
            $booking->delete();

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'Booking Cancelled'
            ], 200);
        }
        catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'status'  => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

     /**
     * Check Availablity for given dates.
     * 
     * @param CheckAvailabilityRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkAvailablity(CheckAvailabilityRequest $request) :JsonResponse
    {

        $fromDate = $request->from_date;
        $toDate = $request->to_date;

        $availablity =  CheckAvailablity::checkAvailability($fromDate, $toDate);
    
        return response()->json([
            'availableSpaces' => $availablity
        ], 200);
    }

    /**
     * Check Pricing for given dates.
     * 
     * @param CheckAvailabilityRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkPricing(CheckAvailabilityRequest $request) :JsonResponse
    {

        //Wasn't sure on this but I basically made sure to at least check for weekend and summer and then just made up some numbers

        $fromDate = $request->from_date;
        $toDate = $request->to_date;

        $day_of_week = date("N", strtotime($fromDate));

        $startMon = date("m", strtotime($fromDate));
        $endMon = date("m", strtotime($toDate));

        $days = $day_of_week + (strtotime($toDate) - strtotime($fromDate)) / (60*60*24);

        $pricing = env('BASE_PRICE') * $days;

        if($days >= 6){
            $pricing = $pricing * env('WEEKEND_PRICE');
        }

        $summerMonths = [4,5,6,7,8,9];

        if(in_array($startMon, $summerMonths) || in_array($endMon, $summerMonths))
        {
            $pricing = $pricing * env('SUMMER_PRICE');
        }
       
        return response()->json([
            'pricing' => $pricing
        ], 200);
    }
}
