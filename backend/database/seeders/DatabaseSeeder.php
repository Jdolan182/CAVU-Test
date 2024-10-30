<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use App\Models\Booking;
use App\Models\ParkingSpace;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $customer = Customer::factory()->create();

        for($i = 0; $i < 5; $i++){
        Booking::factory()
                    ->for($customer)
                    ->for(ParkingSpace::factory())
                    ->create();
        }

        //Using the evn file to create the right amount of space but taking away 5 as I made 5 bookings.
        //Just an easy to get test data with no overlapping spaces
        $parkingSpaces = ParkingSpace::factory()
                    ->count(env('CAR_BOOKING_SPACES') - 5)
                    ->create();
        

    }
}
