<?php

namespace Tests\Feature\Api\Booking;

use Tests\TestCase;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\ParkingSpace;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AmendBookingTest extends TestCase
{
    use RefreshDatabase;

     /**
     * Amend booking validation test.
     *
     * @return void
     */
    public function test_amend_booking_validation_()
    {
        $customer = Customer::factory()->create();

        $parkingSpace = ParkingSpace::factory()->create();

        $booking = Booking::factory()->for($customer)->for($parkingSpace)->create();

        $response = $this->patchJson('/api/booking/update/' . $booking->id, []);
        $response->assertInvalid([
            'car_reg',
            'from_date',
            'to_date',
        ]);
    }

    
     /**
     * Amend booking test.
     *
     * @return void
     */
    public function test_amend_booking_()
    {

        $customer = Customer::factory()->create();

        $parkingSpace = ParkingSpace::factory()->create();

        $booking = Booking::factory()->for($customer)->for($parkingSpace)->create();

        //spare spaces so it always is able to change date without overlap
        $parkingSpace = ParkingSpace::factory()->count(3)->create();


        $response = $this->patchJson('api/booking/update/' . $booking->id, [
            'car_reg'   => 'AA12 DEB',
            'from_date' => '2025-11-04 10:00:00',
            'to_date'   => '2025-11-11 12:00:00'
        ]);

        $response->assertOK();
    }

    /**
     * Amend booking with no availability test.
     *
     * @return void
     */
    public function test_amend_booking_no_availability_()
    {

        //Tests trying to set the date to the current dates and because there's only 1 space you technically have no available spaces

        $customer = Customer::factory()->create();

        $parkingSpace = ParkingSpace::factory()->create();

        $booking = Booking::factory()->for($customer)->for($parkingSpace)->create();

        $response = $this->patchJson('api/booking/update/' . $booking->id, [
            'car_reg'   => 'AA12 DEB',
            'from_date' => $booking->from_date,
            'to_date'   => $booking->to_date
        ]);

        $response->assertOK();
        $response->assertJson(
            [
                'status'  => true,
                'message' => 'No spaces available for given dates'
            ]
        );
    }
}

