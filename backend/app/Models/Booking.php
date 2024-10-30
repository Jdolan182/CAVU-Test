<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
     //
     use HasFactory;

     /**
      * The attributes that are mass assignable.
      *
      * @var array<int, string>
      */
     protected $fillable = [
         'customer_id',
         'parking_space_id',
         'car_reg',
         'from_date',
         'to_date',
     ];
 
     /**
      * The attributes that should be cast.
      *
      * @var array<string, string>
      */
     protected $casts = [
         'from_date' => 'datetime',
         'to_date' => 'datetime',
     ];


    /**
     * 
     * Get the booking customer.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * 
     * Get the space used.
     */
    public function parkingSpace(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
