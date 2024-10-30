<?php

namespace App\Services;

use App\Models\User;
use App\Models\ParkingSpace;


/**
 * Service to check date availablity so we can use it for validation
 */
class CheckAvailablity
{
 
     /**
     * Check Availability 
     * @param Datetime $fromDate
     * @param Datetime $toDate
     * @return \Illuminate\Http\JsonResponse
     */
    public static function checkAvailability($fromDate, $toDate)
    {
        $bookings = ParkingSpace::whereNotIn('id', function($query) use ($toDate, $fromDate){
                    $query->select('parking_space_id')
                            ->where('from_date', '<=', $toDate)
                            ->where('to_date', '>=', $fromDate)
                            ->from('bookings');
                })
                ->get();
       
        return $bookings->count();
    }
}