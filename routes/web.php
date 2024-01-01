<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ModelController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\BikeController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ExcelExportController;
use App\Http\Controllers\LocationPriceController;
use App\Http\Controllers\NotificationController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('invoice-details',[BookingController::class, 'getInvoice']);
Route::get('/', function () {
    return redirect('login');
});


Route::get('get-brands',[BrandController::class, 'getBrands']);
Route::get('get-models',[BrandController::class, 'getModels']);
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('update-token', [App\Http\Controllers\HomeController::class, 'token']);
Route::get('send', [App\Http\Controllers\HomeController::class, 'sendNotification']);

Route::get('download-booking-report', [ExcelExportController::class, 'export']);
Route::get('download-sales-report', [ExcelExportController::class, 'salesExport']);
Route::get('download-gst-report', [ExcelExportController::class, 'gstExport']);

Route::group(['prefix' => 'users', 'middleware'=> ['auth']], function(){
	Route::get('all',[UsersController::class, 'getAllUsers']);
	Route::get('add',[UsersController::class, 'getAddUser']);
	Route::get('delete/{id}',[UsersController::class, 'deleteUser']);
	Route::get('edit/{id}',[UsersController::class, 'editUserPage']);
	Route::post('add',[UsersController::class, 'addUser']);
	Route::get('status/{id}',[UsersController::class, 'changeStatus']);
	Route::get('verify/{id}',[UsersController::class, 'verifyDocument']);
	Route::get('reject/{id}',[UsersController::class, 'rejectDocument']);
	Route::post('edit/{id}',[UsersController::class, 'editUser']);
});

Route::group(['prefix' => 'customers', 'middleware'=> ['auth']], function(){
	Route::get('all',[StudentController::class, 'getAllStudents']);
	Route::get('add',[StudentController::class, 'getAddStudent']);
	Route::get('delete/{id}',[StudentController::class, 'deleteStudent']);
	Route::post('add',[StudentController::class, 'addStudent']);
	Route::get('edit/{id}',[StudentController::class, 'editStudentPage']);
	Route::post('edit/{id}',[StudentController::class, 'postUpdateStudent']);
	Route::post('change-password/{id}',[StudentController::class, 'changePassword']);
	Route::get('status/{id}',[StudentController::class, 'changeStatus']);

	Route::get('verify-adhaar-front/{id}',[StudentController::class, 'verifyDocumentFront']);
	Route::get('verify-adhaar-back/{id}',[StudentController::class, 'verifyDocumentBack']);
	Route::get('verify-driving-license/{id}',[StudentController::class, 'verifyDocumentLicense']);
	Route::get('reject-adhaar-front/{id}',[StudentController::class, 'rejectDocumentFront']);
	Route::get('reject-adhaar-back/{id}',[StudentController::class, 'rejectDocumentBack']);
	Route::get('reject-driving-license/{id}',[StudentController::class, 'rejectDocumentLicense']);
});

Route::group(['prefix' => 'stores', 'middleware'=> ['auth']], function(){
	Route::get('all',[StoreController::class, 'getAllStore']);
	Route::get('add',[StoreController::class, 'getAddStore']);
	Route::get('delete/{id}',[StoreController::class, 'deleteStore']);
	Route::get('edit/{id}',[StoreController::class, 'editStorePage']);
	Route::post('add',[StoreController::class, 'addStore']);
	Route::get('status/{id}',[StoreController::class, 'changeStatus']);
	Route::post('edit/{id}',[StoreController::class, 'editStore']);
});

Route::group(['prefix' => 'bikes', 'middleware'=> ['auth']], function(){
	Route::get('all',[BikeController::class, 'getAllSubjects']);
	Route::get('add',[BikeController::class, 'getAddSubject']);
	Route::get('delete/{id}',[BikeController::class, 'deleteSubject']);
	Route::post('add',[BikeController::class, 'addSubject']);
	Route::get('edit/{id}',[BikeController::class, 'editSubjectPage']);
	Route::post('edit/{id}',[BikeController::class, 'postUpdateSubject']);
	Route::get('status/{id}',[BikeController::class, 'changeStatus']);
});

Route::group(['prefix' => 'categories', 'middleware'=> ['auth']], function(){
	Route::get('all',[CategoryController::class, 'getAllSubjects']);
	Route::get('add',[CategoryController::class, 'getAddSubject']);
	Route::get('delete/{id}',[CategoryController::class, 'deleteSubject']);
	Route::post('add',[CategoryController::class, 'addSubject']);
	Route::get('edit/{id}',[CategoryController::class, 'editSubjectPage']);
	Route::post('edit/{id}',[CategoryController::class, 'postUpdateSubject']);
	Route::get('status/{id}',[CategoryController::class, 'changeStatus']);
});

Route::group(['prefix' => 'brands', 'middleware'=> ['auth']], function(){
	Route::get('all',[BrandController::class, 'getAllChapters']);
	Route::get('add',[BrandController::class, 'getAddChapter']);
	Route::get('delete/{id}',[BrandController::class, 'deleteChapter']);
	Route::post('add',[BrandController::class, 'addChapter']);
	Route::get('edit/{id}',[BrandController::class, 'editChapterPage']);
	Route::post('edit/{id}',[BrandController::class, 'postUpdateChapter']);
	Route::get('status/{id}',[BrandController::class, 'changeStatus']);
});

Route::group(['prefix' => 'models', 'middleware'=> ['auth']], function(){
	Route::get('all',[ModelController::class, 'getAllChapters']);
	Route::get('add',[ModelController::class, 'getAddChapter']);
	Route::get('delete/{id}',[ModelController::class, 'deleteChapter']);
	Route::post('add',[ModelController::class, 'addChapter']);
	Route::get('edit/{id}',[ModelController::class, 'editChapterPage']);
	Route::post('edit/{id}',[ModelController::class, 'postUpdateChapter']);
	Route::get('status/{id}',[ModelController::class, 'changeStatus']);
});

Route::group(['prefix' => 'mcq-questions', 'middleware'=> ['auth']], function(){
	Route::get('all',[QuestionController::class, 'getAllQuestions']);
	Route::get('add',[QuestionController::class, 'getAddQuestion']);
	Route::get('delete/{id}',[QuestionController::class, 'deleteQuestion']);
	Route::post('add',[QuestionController::class, 'addQuestion']);
	Route::get('edit/{id}',[QuestionController::class, 'editChapterPage']);
	Route::post('edit/{id}',[QuestionController::class, 'postUpdateChapter']);
	Route::get('status/{id}',[QuestionController::class, 'changeStatus']);
});

Route::group(['prefix' => 'bookings', 'middleware'=> ['auth']], function(){
	Route::get('all',[BookingController::class, 'getAllBooking']);
	Route::get('invoice-details/{id}',[BookingController::class, 'getInvoice']);
	Route::get('delete/{id}',[BookingController::class, 'deleteBooking']);
	Route::get('edit/{id}',[BookingController::class, 'editBookingPage']);
	Route::post('add',[BookingController::class, 'addBooking']);
	Route::post('status/{id}',[BookingController::class, 'changeStatus']);
	Route::post('edit/{id}',[BookingController::class, 'editBooking']);
});

Route::group(['prefix' => 'prices', 'middleware'=> ['auth']], function(){
	Route::get('all',[PriceController::class, 'getAllPricing']);
	Route::get('add',[PriceController::class, 'getAddPricing']);
	Route::get('delete/{id}',[PriceController::class, 'deletePricing']);
	Route::get('edit/{id}',[PriceController::class, 'editPricingPage']);
	Route::post('add',[PriceController::class, 'addPricing']);
	Route::get('status/{id}',[PriceController::class, 'changeStatus']);
	Route::post('edit/{id}',[PriceController::class, 'editPricing']);
});

Route::group(['prefix' => 'locations', 'middleware'=> ['auth']], function(){
	Route::get('all',[LocationController::class, 'getAllLocation']);
	Route::get('add',[LocationController::class, 'getAddLocation']);
	Route::get('delete/{id}',[LocationController::class, 'deleteLocation']);
	Route::get('edit/{id}',[LocationController::class, 'editLocationPage']);
	Route::post('add',[LocationController::class, 'addLocation']);
	Route::get('status/{id}',[LocationController::class, 'changeStatus']);
	Route::post('edit/{id}',[LocationController::class, 'editLocation']);
});

Route::group(['prefix' => 'offers', 'middleware'=> ['auth']], function(){
	Route::get('all',[OfferController::class, 'getAllOffers']);
	Route::get('add',[OfferController::class, 'getAddOffer']);
	Route::get('delete/{id}',[OfferController::class, 'deleteOffer']);
	Route::post('add',[OfferController::class, 'addOffer']);
	Route::get('edit/{id}',[OfferController::class, 'editOfferPage']);
	Route::post('edit/{id}',[OfferController::class, 'postUpdateOffer']);
	Route::get('status/{id}',[OfferController::class, 'changeStatus']);
});

	Route::get('registration-reports/all',[ReportController::class, 'getAllRegisteredUsers'])->middleware('auth');
	Route::get('gst-reports/all',[ReportController::class, 'getAllFinancialReports'])->middleware('auth');
	Route::get('sales-reports/all',[ReportController::class, 'getAllCancellationReports'])->middleware('auth');
	Route::get('booking-reports/all',[ReportController::class, 'getAllBookingReports'])->middleware('auth');

	Route::group(['prefix' => 'location-prices', 'middleware'=> ['auth']], function(){
	Route::get('all',[LocationPriceController::class, 'getAllPricing']);
	Route::get('add',[LocationPriceController::class, 'getAddPricing']);
	Route::get('delete/{id}',[LocationPriceController::class, 'deletePricing']);
	Route::get('edit/{id}',[LocationPriceController::class, 'editPricingPage']);
	Route::post('add',[LocationPriceController::class, 'addPricing']);
	Route::get('status/{id}',[LocationPriceController::class, 'changeStatus']);
	Route::post('edit/{id}',[LocationPriceController::class, 'editPricing']);
});

	Route::group(['prefix' => 'notifications', 'middleware'=> ['auth']], function(){
	// Route::get('all',[NotificationController::class, 'getAllNotifications']);
	Route::get('/',[NotificationController::class, 'getAddNotification']);
	Route::post('add',[NotificationController::class, 'addNotification']);
	// Route::get('delete/{id}',[NotificationController::class, 'deleteNotification']);
	// Route::get('edit/{id}',[NotificationController::class, 'editNotificationPage']);
	// Route::post('edit/{id}',[NotificationController::class, 'postUpdateNotification']);
	// Route::get('status/{id}',[NotificationController::class, 'changeStatus']);
});