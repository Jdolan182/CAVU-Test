<?php

namespace Tests\Feature\Api\Booking;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\ParkingSpace;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CancelBookingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Cancel test.
     *
     * @return void
     */
    public function test_cancel_booking_()
    {

        $booking = Booking::factory()->for(Customer::factory())->for(ParkingSpace::factory())->create();

        $response = $this->deleteJson('api/booking/delete/' . $booking->id);
        $response->assertOk();
        $response->assertJson(
            [
                'status'  => true,
                'message' => 'Booking Cancelled'
            ]
        );
    }
}

