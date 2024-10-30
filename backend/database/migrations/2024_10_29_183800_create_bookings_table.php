<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();           
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('parking_space_id');
            $table->string('car_reg');
            $table->timestamp('from_date');   
            $table->timestamp('to_date');   
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('parking_space_id')->references('id')->on('parking_spaces');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
