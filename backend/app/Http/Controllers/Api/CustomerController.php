<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Customer\CustomerCreateRequest;
use App\Http\Requests\Customer\CustomerUpdateRequest;
use App\Http\Resources\Customer\CustomerResource;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    /**
     * Store the customer
     * 
     * @param CustomerCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CustomerCreateRequest $request) :JsonResponse
    {
        
        DB::beginTransaction();

        try{
            $customer = Customer::create([
                'first_name' => $request->input('first_name'),
                'last_name'  => $request->input('last_name'),
                'email'      => $request->input('email'),
                'password'   => Hash::make($request->input('password')),
            ]);

            DB::commit();

            return response()->json([
                'status'   => true,
                'message'  => 'Customer Created',
                'customer' => $customer
            ], 201);
        }
        catch (\Throwable $th) {

            DB::rollback();

            return response()->json([
                'status'  => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the customer.
     */
    public function show(Customer $customer) :CustomerResource
    {
        return new CustomerResource($customer);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

     /**
     * Update Customer Details.
     *
     * @param CustomerUpdateRequest $request
     * @param Customer $customer
     * @return App\Http\Resources\Customer\CustomerResource
     */
    public function update(CustomerUpdateRequest $request, Customer $customer) :CustomerResource
    {
        //
        DB::beginTransaction();

        try{
            $customer->update([
                'name'     => $request->input('name'),
                'email'    => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);

            DB::commit();

            return new CustomerResource($customer->refresh());
        }
        catch (\Throwable $th) {

            DB::rollback();

            return response()->json([
                'status'  => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
