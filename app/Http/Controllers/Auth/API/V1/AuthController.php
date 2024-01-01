<?php

namespace App\Http\Controllers\Auth\API\V1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\UserServices;
use App\Http\Requests\SignUpRequest;
use App\Http\Requests\ImageRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\VerifyOTPRequest;
use App\Services\StandardService;
use App\Services\QuestionService;
use App\Services\SubjectService;
use App\Services\ChapterService;
use App\Services\BookmarkService;
use App\Services\BookingService;
use App\Services\EnquiryService;
use App\Services\OfferService;
use App\Services\VehicleService;
use App\Services\NotificationService;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\ChapterRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Auth;

class AuthController extends Controller
{
    protected $UserService;
    protected $QuestionService;
    protected $StandardService;
    protected $SubjectService;
    protected $ChapterService;
    protected $BookmarkService;
    protected $OfferService;
    protected $VehicleService;
    protected $EnquiryService;
    protected $BookingService;
    protected $NotificationService;
    
    public function __construct()
    {
        $this->UserService = new UserServices();
        $this->StandardService = new StandardService();
        $this->SubjectService = new SubjectService();
        $this->ChapterService = new ChapterService();
        $this->QuestionService = new QuestionService();
        $this->BookmarkService = new BookmarkService();
        $this->OfferService = new OfferService();
        $this->VehicleService = new VehicleService();
        $this->EnquiryService = new EnquiryService();
        $this->BookingService = new BookingService();
        $this->NotificationService = new NotificationService();
    }

    public function applyCouponCode(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = $request->user()->id ?? 0;
        return $this->BookingService->applyCode($data);
        
    }


    public function register(SignUpRequest $request)
    {

        $user_data = $request->all();
        $user_data['is_verified'] = 1;
        $user_data['otp'] = 1234;
        $check_user = $this->UserService->checkIsUserExists($user_data);

        if($check_user) {
            return response()->json([
                'status' => false,
                'message' => 'You already have an account please Sign in',
            ]);
        }

        if ($user_data['is_verified']) {
            $user_data['is_active'] = 1;
            $response = $this->UserService->createUser($user_data);
            return response()->json([
                'status' => true,
                'message' => 'User created successfully',
                'user' => $response
            ]);
        }
    }

    public function login(RegisterRequest $request)
    {
        $user_data = $request->all();
        $check_user = $this->UserService->checkIsUserExists($user_data);

        if(!$check_user) {
            return response()->json([
                'status' => false,
                'message' => 'User does not exists',
            ]);
        }
        

        if($check_user && !$check_user->is_active) {
            return response()->json([
                'status' => false,
                'message' => 'User account access restricted',
            ]);
        }

            $credentials = $request->only('email', 'password');
            
            //Request is validated
            //Create token
            try {
                // dd(Config::set('auth.providers.registrations.model', \App\Registration::class));
                if (!$token = JWTAuth::attempt($credentials)) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Login credentials are invalid.',
                    ]);
                }
            }
            catch (JWTException $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Could not create token.',
                ]);
            }

            //Token created, return with success response and jwt token
            return response()->json([
                'status' => true,
                'message' => 'Login successfully',
                'token' => $token,
                'user' => Auth::user()
            ]);
    }
    
    public function mobileLogin(RegisterRequest $request)
    {
        $user_data = $request->all();
        $check_user = $this->UserService->checkIsUserExistsMobile($user_data);

        if(!$check_user) {
            return response()->json([
                'status' => false,
                'message' => 'User does not exists',
            ]);
        }
        if($check_user && !$check_user->is_active) {
            return response()->json([
                'status' => false,
                'message' => 'User account access restricted',
            ]);
        }

        $credentials = $request->only('contact_number', 'otp');

        try {
                // dd(Config::set('auth.providers.registrations.model', \App\Registration::class));
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Login credentials are invalid.',
                ]);
            }
        }
        catch (JWTException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Could not create token.',
            ]);
        }

            //Token created, return with success response and jwt token
        return response()->json([
            'status' => true,
            'message' => 'Login successfully',
            'token' => $token,
            'user' => Auth::user()
        ]);
    }

    public function sendOTP(Request $request)
    {
        $user_data = $request->all();
        $response = $this->UserService->sendOTP($user_data);
        if($response)
        {
            return response()->json([
                'status' => true,
                'message' => 'OTP Sent Successfully',
                'otp' => $response
            ]);
        }
        else {
            return response()->json([
                'status' => false,
                'message' => 'User Does Not Exists',
            ]);
        }
    }

    public function updateProfile(ProfileRequest $request)
    {
        $user_data = $request->all();
        $user_data['user_id'] = $request->user()->id ?? 0;
        return $response =  $this->UserService->updateProfile($user_data);
    }
    
    public function getProfile(Request $request)
    {
        $user_data = $request->all();
        $user_id = $request->user()->id ?? 0;
        $response =  $this->UserService->getProfile($user_id);
        if($response)
        {
            return response()->json([
                'status' => true,
                'message' => 'User details',
                'user' => $response
            ]);
        }
        else {
            return response()->json([
                'status' => false,
                'message' => 'User does not exists',
            ]);
        }
    }

    public function getOffers(Request $request)
    {
        $user_id = $request->user()->id ?? 0;
        $response =  $this->OfferService->getOffers($user_id);
        if(count($response))
        {
            return response()->json([
                'status' => true,
                'message' => 'Offer details',
                'offers' => $response
            ]);
        }
        else {
            return response()->json([
                'status' => false,
                'message' => 'Record not found',
            ]);
        }
    }
    
    public function uploadDocument(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = $request->user()->id ?? 0;
        $response =  $this->UserService->uploadDocument($data);
        if($response){
            return response()->json([
                'status' => true,
                'message' => 'Document uploaded successfully'
            ]);
        }
        else
        {
            return response()->json([
                'status' => false,
                'message' => 'Unable to upload',
            ]);
        }
    }
    
    public function getVehicles(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = $request->user()->id ?? 0;
        $response =  $this->VehicleService->getVehicles($data);
        if(count($response)){
            return response()->json([
                'status' => true,
                'message' => 'Bike loaded successfully',
                'bikes' => $response
            ]);
        }
        else
        {
            return response()->json([
                'status' => false,
                'message' => 'Record not found',
            ]);
        }
    }
    
    public function submitEnquiry(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = $request->user()->id ?? 0;
        $response =  $this->EnquiryService->create($data);
        if($response){
            return response()->json([
                'status' => true,
                'message' => 'Enquiry submitted successfully'
            ]);
        }
        else
        {
            return response()->json([
                'status' => false,
                'message' => 'Unable to submit',
            ]);
        }
    }
    
    public function getVehicleDetails(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = $request->user()->id ?? 0;
        $response =  $this->VehicleService->get($data);
        if($response){
            return response()->json([
                'status' => true,
                'message' => 'Vehicle details',
                'bike_details' => $response
            ]);
        }
        else
        {
            return response()->json([
                'status' => false,
                'message' => 'Record not found',
            ]);
        }
    }
    
    public function getFilteredVehicles(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = $request->user()->id ?? 0;
        $response =  $this->VehicleService->getFilteredVehicles($data);
        if(count($response)){
            return response()->json([
                'status' => true,
                'message' => 'Bike loaded successfully',
                'bikes' => $response
            ]);
        }
        else
        {
            return response()->json([
                'status' => false,
                'message' => 'Record not found',
            ]);
        }
    }
    
    public function getAllCategories(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = $request->user()->id ?? 0;
        $response =  $this->VehicleService->getAllCategories($data);
        if(count($response)){
            return response()->json([
                'status' => true,
                'message' => 'Categories loaded successfully',
                'categories' => $response
            ]);
        }
        else
        {
            return response()->json([
                'status' => false,
                'message' => 'Record not found',
            ]);
        }
    }

    public function getAllBrands(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = $request->user()->id ?? 0;
        $response =  $this->VehicleService->getAllBrands($data);
        if(count($response)){
            return response()->json([
                'status' => true,
                'message' => 'Brands loaded successfully',
                'brands' => $response
            ]);
        }
        else
        {
            return response()->json([
                'status' => false,
                'message' => 'Record not found',
            ]);
        }
    }

    public function getAllModels(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = $request->user()->id ?? 0;
        $response =  $this->VehicleService->getAllModels($data);
        if(count($response)){
            return response()->json([
                'status' => true,
                'message' => 'Models loaded successfully',
                'models' => $response
            ]);
        }
        else
        {
            return response()->json([
                'status' => false,
                'message' => 'Record not found',
            ]);
        }
    }
    
    
    
    public function addBookingRequest(Request $request)
    {
        $data = $request->all();
        // $myAudioFile = asset('assets/main-audio.wav');
        $data['user_id'] = $request->user()->id ?? 0;
        $response =  $this->BookingService->add($data);
        if($response)
        {
            return response()->json([
                'status' => true,
                'message' => 'Booking requested successfully',
                'booking_details' => $response
            ]);
        }
        else
        {
            return response()->json([
                'status' => false,
                'message' => 'Vehicle already booked , please try another',
            ]);
        }
    }

    public function addBookingRequestImages(ImageRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = $request->user()->id ?? 0;
        $response =  $this->BookingService->addImage($data);
        if($response)
        {
            return response()->json([
                'status' => true,
                'message' => 'Booking images added successfully',
                'booking_details' => $response
            ]);
        }
        else
        {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
            ]);
        }
    }

    public function bookingList(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = $request->user()->id ?? 0;
        $response =  $this->BookingService->getBooking($data);
        if(count($response))
        {
            return response()->json([
                'status' => true,
                'message' => 'Bookings loaded successfully',
                'booking_list' => $response
            ]);
        }
        else
        {
            return response()->json([
                'status' => false,
                'message' => 'Booking not found',
            ]);
        }
    }

    public function bookingDetails(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = $request->user()->id ?? 0;
        $response =  $this->BookingService->getBookingDetails($data);
        if($response)
        {
            return response()->json([
                'status' => true,
                'message' => 'Bookings details loaded successfully',
                'booking_details' => $response
            ]);
        }
        else
        {
            return response()->json([
                'status' => false,
                'message' => 'Booking not found',
            ]);
        }   
    }
    
    public function getLocations(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = $request->user()->id ?? 0;
        $response =  $this->BookingService->getLocationDetails($data);
        if(count($response))
        {
            return response()->json([
                'status' => true,
                'message' => 'Locations loaded successfully',
                'location_details' => $response
            ]);
        }
        else
        {
            return response()->json([
                'status' => false,
                'message' => 'Record not found',
            ]);
        }   
    }
    
    public function getAmountDetails(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = $request->user()->id ?? 0;
        $response =  $this->BookingService->getAmountDetails($data);
        if(count($response))
        {
            return response()->json([
                'status' => true,
                'message' => 'price loaded successfully',
                'price_details' => $response
            ]);
        }
        else
        {
            return response()->json([
                'status' => false,
                'message' => 'Record not found',
            ]);
        }   
    }

    public function getKmDetails(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = $request->user()->id ?? 0;
        $response =  $this->BookingService->getKmDetails($data);
        if(count($response))
        {
            return response()->json([
                'status' => true,
                'message' => 'pricing loaded successfully',
                'km_details' => $response
            ]);
        }
        else
        {
            return response()->json([
                'status' => false,
                'message' => 'Record not found',
            ]);
        }   
    }
    
    public function getStatus()
    {
        $response =  $this->BookingService->getStatus();
        if(count($response))
        {
            return response()->json([
                'status' => true,
                'message' => 'status loaded successfully',
                'status_details' => $response
            ]);
        }
        else
        {
            return response()->json([
                'status' => false,
                'message' => 'Record not found',
            ]);
        }  
    }
    
    public function updateStatus(Request $request)
    {
        $data = $request->all();
        $response =  $this->BookingService->updateStatus($data);
        if($response)
        {
            return response()->json([
                'status' => true,
                'message' => 'status updated successfully'
            ]);
        }
        else
        {
            return response()->json([
                'status' => false,
                'message' => 'Unable to update',
            ]);
        }  
    }
    
    
    public function changePassword(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = $request->user()->id ?? 0;
        $response =  $this->UserService->changePassword($data);
        if($response)
        {
            return response()->json([
                'status' => true,
                'message' => 'Password updated successfully'
            ]);
        }
        else
        {
            return response()->json([
                'status' => false,
                'message' => 'Unable to change password',
            ]);
        }  
    }
    
    public function forgotPassword(Request $request)
    {
        $data = $request->all();
        $response =  $this->UserService->forgotPassword($data);
        if($response)
        {
            return response()->json([
                'status' => true,
                'message' => 'Password changed successfully'
            ]);
        }
        else
        {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
            ]);
        }  
    }
    
    public function sendBooking(Request $request)
    {
        $data = $request->all();
        $response =  $this->BookingService->sendBookingConfirmation($data);
        if($response)
        {
            return response()->json([
                'status' => true,
                'message' => 'Message sent successfully'
            ]);
        }
        else
        {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
            ]);
        }  
    }
    
    public function updateToken(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = $request->user()->id ?? 0;
        $response =  $this->UserService->updateToken($data);
        if($response)
        {
            return response()->json([
                'status' => true,
                'message' => 'Token updated successfully'
            ]);
        }
        else
        {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
            ]);
        }  
    }

    public function getNotifications(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = $request->user()->id ?? 0;
        $response =  $this->NotificationService->getNotifications($data);
        if($response)
        {
            return response()->json([
                'status' => true,
                'message' => 'Notifications loaded successfully',
                'data' => $response
            ]);
        }
        else
        {
            return response()->json([
                'status' => false,
                'message' => 'Not found',
            ]);
        }  
    }

    public function deleteAccount(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = $request->user()->id ?? 0;
        $response =  $this->NotificationService->deleteAccount($data);
        if($response)
        {
            return response()->json([
                'status' => true,
                'message' => 'Account deactivated successfully'
            ]);
        }
        else
        {
            return response()->json([
                'status' => false,
                'message' => 'Not found',
            ]);
        }  
    }
    
    
}
