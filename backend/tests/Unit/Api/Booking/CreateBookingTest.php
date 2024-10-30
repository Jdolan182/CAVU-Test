<?php

namespace Tests\Feature\Api\Booking;

use Tests\TestCase;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\ParkingSpace;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateBookingTest extends TestCase
{
    use RefreshDatabase;
    
     /**
     * Create booking test.
     *
     * @return void
     */
    public function test_create_booking_()
    {

        $count = Booking::count();

        $customer = Customer::factory()->create();

        $parkingSpace = ParkingSpace::factory()->create();

        $response = $this->postJson('api/booking/store',[
            'customer_id'      => $customer->id,
            'parking_space_id' => $parkingSpace->id,
            'car_reg'          => 'AA12 DEB',
            'from_date'        => '2024-11-04 10:00:00',
            'to_date'          => '2024-11-11 12:00:00'
        ]);

        $response->assertCreated();
        $this->assertGreaterThan($count, Booking::count(), 'Record has been created');
    }

    /**
     * Create booking with no availability test.
     *
     * @return void
     */
    public function test_create_booking_no_availability_()
    {

        //Tests trying to set the date to the current dates and because there's only 1 space you technically have no available spaces

        $customer = Customer::factory()->create();

        $parkingSpace = ParkingSpace::factory()->create();

        $booking = Booking::factory()->for($customer)->for($parkingSpace)->create();

        $this->postJson('api/booking/store',[
            'customer_id'      => $customer->id,
            'parking_space_id' => $parkingSpace->id,
            'car_reg'          => 'AA12 DEB',
            'from_date'        => '2024-11-04 10:00:00',
            'to_date'          => '2024-11-11 12:00:00'
        ]);

        $response = $this->postJson('api/booking/store',[
            'customer_id'      => $customer->id,
            'parking_space_id' => $parkingSpace->id,
            'car_reg'          => 'AA12 DEB',
            'from_date'        => '2024-11-04 10:00:00',
            'to_date'          => '2024-11-11 12:00:00'
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

