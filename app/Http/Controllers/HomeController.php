<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookingRequest;
use App\Models\Bike;
use App\Models\User;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $day = date('Y-m-d');
        $today = BookingRequest::whereDate('created_at',$day);
        if(Auth::user()->role_id !=1)
        {
            $today = $today->with('vehicles')
                    ->whereHas('vehicles', function ($query){
                        $query->where('dealer_id', Auth::user()->id);
                    });
        }
        $bookings['today'] = $today->count();
        $bookings['ongoing'] = BookingRequest::whereNotIn('booking_status',[8,6,7]);
        if(Auth::user()->role_id !=1)
        {
            $bookings['ongoing'] = $bookings['ongoing']->with('vehicles')
                    ->whereHas('vehicles', function ($query){
                        $query->where('dealer_id', Auth::user()->id);
                    });
        }
        $bookings['ongoing'] = $bookings['ongoing']->count();
        $bookings['cancelled'] = BookingRequest::where('booking_status',8);
        if(Auth::user()->role_id !=1)
        {
            $bookings['cancelled'] = $bookings['cancelled']->with('vehicles')
                    ->whereHas('vehicles', function ($query){
                        $query->where('dealer_id', Auth::user()->id);
                    });
        }
        $bookings['cancelled'] = $bookings['cancelled']->count();
        
        $bookings['completed'] = BookingRequest::where('booking_status',6);
        if(Auth::user()->role_id !=1)
        {
            $bookings['completed'] = $bookings['completed']->with('vehicles')
                    ->whereHas('vehicles', function ($query){
                        $query->where('dealer_id', Auth::user()->id);
                    });
        }
        $bookings['completed'] = $bookings['completed']->count();
        
        $users['all'] = User::where('role_id',3)->count();
        $users['verified'] = User::where('role_id',3)->where('is_document_verified',1)->count();
        $users['unverified'] = User::where('role_id',3)->where('is_document_verified',0)->count();
        
        $users1 = User::where('role_id',3)->where('is_active',1)->get();
        $zeroCount = 0;
        foreach($users1 as $user)
        {
            $check = BookingRequest::where('customer_id',$user->id)->first();
            if(!$check)
            {
                $zeroCount ++;
            }
        }
        $users['zero'] = $zeroCount;
        return view('home',compact('bookings','users'));
    }
    
    public function token(Request $request)
    {
        $user = \Auth::user()->id ?? 0;
        $data = User::where('id',$user)->first();
        if($data)
        {
            if($data->firebase_token==null)
            {
                $data->firebase_token = $request->token;
            }
            else
            {
                $ids = explode(",",$data->firebase_token);
                if(!in_array($request->token, $ids))
                {
                    $data->firebase_token = $data->firebase_token.",".$request->token;
                }
            }
            $data->save();
            return true;
        }
    }
    
    public function sendNotification()
{
    $user = \Auth::user()->id ?? 0;
    $data = User::where('id',$user)->first();
    
    $url ="https://fcm.googleapis.com/fcm/send";
    
        $fields=array(
            "to"=>$data->firebase_token,
            "notification"=>array(
                "body"=>"Ijaj",
                "title"=>"Ijaj has booked vehicle now",
                "icon"=>"https://vegobike.in/admin/assets/pictures/app_logo.png",
                "click_action"=>"{{url('/')}}"
            )
        );
    
    
       
        $headers=array(
            'Authorization: key=AAAAmY6h4T4:APA91bEWkf72i7DiqUoXuC8w6a3suqutZJmtDWaOA7W3qA9l_6ACcj-fmI4hmXZehBy9KUyfJTcIoqzPHsmwf3uqz41Nq0EDvrbYk_hra1o_Jm1DjIQsGQih-WIbQuqDTxfbggjTd4Xn',
            'Content-Type:application/json'
        );

        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,true);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($fields));
        $result=curl_exec($ch);
        // print_r($result);
        curl_close($ch);
        return $result;
}
    
}
