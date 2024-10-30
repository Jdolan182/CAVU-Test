<?php

namespace Tests\Feature\Api\Booking;

use Tests\TestCase;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\ParkingSpace;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CheckAvailabilityTest extends TestCase
{
    use RefreshDatabase;
    
     /**
     * Check availability test.
     *
     * @return void
     */
    public function test_check_availability_()
    {

        $customer = Customer::factory()->create();

        for($i = 0; $i < 5; $i++){
            Booking::factory()
                    ->for($customer)
                    ->for(ParkingSpace::factory())
                    ->create();
        }


        $fromDate = '2025-11-10 04:00:00';
        $toDate = '2025-11-10 04:00:00';

        $response = $this->getJson('api/booking/checkAvailability' . '?from_date=' . $fromDate . '&to_date=' . $toDate);
        $response->assertOk();
        $response->assertJson(fn (AssertableJson $json) =>
            $json->whereType('availableSpaces', 'integer') 
        );
    }
}

