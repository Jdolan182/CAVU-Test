<?php

namespace Tests\Feature\Api\Booking;

use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CheckPricingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Check pricing test.
     *
     * @return void
     */
    public function test_check_pricing_()
    {

        $fromDate = '2024-11-10 04:00:00';
        $toDate = '2024-11-10 04:00:00';

        $response = $this->getJson('api/booking/checkPricing' . '?from_date=' . $fromDate . '&to_date=' . $toDate);
        $response->assertOk();
        $response->assertJson(fn (AssertableJson $json) =>
            $json->whereType('pricing', 'double') 
        );
    }
}

