<?php

namespace Tests\Feature\Api\Customer;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateCustomerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Create customer test.
     *
     * @return void
     */
    public function test_create_customer_()
    {
        $count = Customer::count();

        $response = $this->postJson('api/customer/store', [
            'first_name'            => 'First Name',
            'last_name'             => 'Last Name',
            'email'                 => 'user@email.com',
            'password'              => 'password',
            'password_confirmation' => 'password'
        ]);

        $response->assertCreated();
        $this->assertGreaterThan($count, Customer::count(), 'Record has been created');
    }
}

