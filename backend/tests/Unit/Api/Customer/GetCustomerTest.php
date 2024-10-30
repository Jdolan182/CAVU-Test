<?php

namespace Tests\Feature\Api\Customer;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetCustomerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Get customer test.
     *
     * @return void
     */
    public function test_get_customer_()
    {
        $customer = Customer::factory()->create();

        $response = $this->getJson('api/customer/show/' . $customer->id);
        $response->assertOk();
        $response->assertJson(
            [
                'data' => [
                    'id'         => $customer->id,
                    'first_name' => $customer->first_name,
                    'last_name'  => $customer->last_name,
                    'email'      => $customer->email,
                ],
            ]
        );
    }
}

