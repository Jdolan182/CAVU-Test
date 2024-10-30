<?php

use Illuminate\Support\Facades\Route;

//Controllers
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\BookingController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/





//customer
Route::get('/customer/show/{customer}', [CustomerController::class, 'show']);
Route::post('/customer/store', [CustomerController::class, 'store']);
Route::patch('/customer/update/{customer}', [CustomerController::class, 'update']);

//blog
Route::get('/booking/show/{booking}', [BookingController::class, 'show']);
Route::post('/booking/store', [BookingController::class, 'store']);
Route::patch('/booking/update/{blog}', [BookingController::class, 'update']);
Route::delete('/booking/delete/{blog}', [BookingController::class, 'delete']);
Route::get('/booking/checkAvailability', [BookingController::class, 'checkAvailablity']);
Route::get('/booking/checkPricing', [BookingController::class, 'checkPricing']);



