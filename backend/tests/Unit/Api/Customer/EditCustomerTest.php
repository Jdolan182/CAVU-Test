<?php

namespace Tests\Feature\Api\Customer;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EditCustomerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Update customer validation test.
     *
     * @return void
     */
    public function test_edit_customer_validation_()
    {
        $customer = Customer::factory()->create();

        $response = $this->patchJson('/api/customer/update/' . $customer->id, []);
        $response->assertInvalid([
            'first_name',
            'last_name',
            'email',
            'password',
        ]);
    }

    /**
     * Update customer test.
     *
     * @return void
     */
    public function test_edit_customer_()
    {
        $customer = Customer::factory()->create();

        $response = $this->patchJson('api/customer/update/' . $customer->id, [
            'first_name'            => 'First Name',
            'last_name'             => 'Last Name',
            'email'                 => 'user@email.com',
            'password'              => 'password',
            'password_confirmation' => 'password'
        ]);

        $response->assertOK();
    }
}

