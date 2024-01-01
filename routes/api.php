<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\API\V1\AuthController;

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

    Route::post('login', [AuthController::class, 'mobileLogin']);
    Route::post('mobile-login', [AuthController::class, 'login']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('send-otp', [AuthController::class, 'sendOTP']);
    Route::group(['middleware' => ['jwt.verify']], function(){
    Route::get('get-profile', [AuthController::class, 'getProfile']);
    Route::get('get-offers', [AuthController::class, 'getOffers']);
    Route::post('update-profile', [AuthController::class, 'updateProfile']);
    Route::post('upload-document', [AuthController::class, 'uploadDocument']);
	Route::post('get-vehicles', [AuthController::class, 'getVehicles']);
	Route::post('submit-enquiry', [AuthController::class, 'submitEnquiry']);
	Route::post('get-vehicle-details', [AuthController::class, 'getVehicleDetails']);
	Route::post('get-filtered-vehicles', [AuthController::class, 'getFilteredVehicles']);
	Route::post('get-notifications', [AuthController::class, 'getNotifications']);
	Route::post('deactivate-account', [AuthController::class, 'deleteAccount']);
	
	Route::get('get-categories', [AuthController::class, 'getAllCategories']);
	Route::post('get-brands', [AuthController::class, 'getAllBrands']);
	Route::post('get-models', [AuthController::class, 'getAllModels']);
	
	Route::post('booking-request', [AuthController::class, 'addBookingRequest']);
	Route::post('booking-request-images', [AuthController::class, 'addBookingRequestImages']);
	Route::get('get-bookings', [AuthController::class, 'bookingList']);
	Route::post('booking-details', [AuthController::class, 'bookingDetails']);
	
	Route::get('get-locations', [AuthController::class, 'getLocations']);
	Route::post('get-amount-details', [AuthController::class, 'getAmountDetails']);
	Route::post('get-km-details', [AuthController::class, 'getKmDetails']);
	Route::get('get-status', [AuthController::class, 'getStatus']);
	Route::post('update-status', [AuthController::class, 'updateStatus']);

	Route::post('apply-code', [AuthController::class, 'applyCouponCode']);
	
	Route::post('change-password', [AuthController::class, 'changePassword']);
	Route::post('update-token', [AuthController::class, 'updateToken']);

});

Route::post('send', [AuthController::class, 'sendBooking']);
