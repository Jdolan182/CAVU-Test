<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;

class BookingCreateRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
       
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'customer_id' => [
                'required',
                'numeric',
            ],
            'parking_space_id' => [
                'required',
                'numeric',
            ],
            'car_reg' => [
                'required',
                'string',
                'max:8',
            ],
            'from_date' =>[ 
                'required',
                'date',
            ],
            'to_date' =>[ 
                'required',
                'date',
            ]
        ];
    }
}
 