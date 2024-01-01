<?php

namespace App\Services;

use App\Models\BookingBike;
use App\Models\PriceList;
use App\Models\User;
use App\Models\Bike;
use App\Models\LocationMaster;
use App\Models\BookingRequest;
use App\Models\BookingStatus;
use App\Models\Store;
use App\Models\Offer;
use App\Models\LocationPriceList;

use Storage;

class BookingService
{
    protected $BookingBikeModel;
    protected $LocationMasterModel;
    protected $BookingRequestModel;
    protected $BookingStatusModel;
    protected $PriceListModel;
    protected $LocationPriceListModel;
    protected $StoreModel;
    protected $UserModel;
    protected $BikeModel;
    protected $OfferModel;

    public function __construct()
    {
        $this->BookingBikeModel = new BookingBike();
        $this->BookingRequestModel = new BookingRequest();
        $this->BookingStatusModel = new BookingStatus();
        $this->LocationMasterModel = new LocationMaster();
        $this->PriceListModel = new PriceList();
        $this->StoreModel = new Store();
        $this->UserModel = new User();
        $this->BikeModel = new Bike();
        $this->OfferModel = new Offer();
        $this->LocationPriceListModel = new LocationPriceList();
    }

    public function addImage($data = [])
    {
        if(isset($data['all_images']) && count($data['all_images']) > 0) {
            foreach($data['all_images'] as $image)
            {
                $data['images'] = $image->store('booking_requested_images');
                $this->BookingBikeModel->create($data);
            }
            
            return 1;
        }
        return null;
    }

    public function add($data = [])
    {
        if (isset($data['id'])) {
            $record = $this->BookingRequestModel->find($data['id']);
        } else {
            $record = $this->BookingRequestModel;
        }
        $data['start_date'] = date('Y-m-d H:i:s', strtotime($data['start_date']));
        $data['end_date'] = date('Y-m-d H:i:s', strtotime($data['end_date']));

        $data['start_date1'] = date('Y-m-d', strtotime($data['start_date']));
        $data['end_date1'] = date('Y-m-d', strtotime($data['end_date']));


        $start_date = $data['start_date'] ?? $record['start_date'];
        $end_date = $data['end_date'] ?? $record['end_date'];

        $booking_count = $this->BookingRequestModel->count();
        if ($booking_count == 0) {
            $booking_id_count = "VEGO00" . $booking_count + 1;
        } else if ($booking_count < 10) {
            $booking_id_count = "VEGO00" . $booking_count + 1;
        } else if ($booking_count >= 10 && $booking_count < 100) {
            $booking_id_count = "VEGO0" . $booking_count + 1;
        } else if ($booking_count >= 100 && $booking_count < 1000) {
            $booking_id_count = "VEGO" . $booking_count + 1;
        }


        $bike =  $this->BikeModel->where('id', $data['vehicle_id'])->first();
        $check = $this->BookingRequestModel->where('vehicle_id', $bike->id)->where('start_date1', '<=', $data['start_date1'])->orderBy('start_date1', 'DESC')->first();
        if ($check) {
            if ($check->end_date1 <= $data['start_date1']) {
                $bike->is_available = 1;
            } else {
                if ($check->booking_status == 4 || $check->booking_status == 6 || $check->booking_status == 8) {
                    $bike->is_available = 1;
                } else {
                    return false;
                }
            }
        } else {
            $bike->is_available = 1;
        }

        $record->vehicle_id = $data['vehicle_id'] ?? 0;
        $record->booking_id = $booking_id_count;
        $record->start_date = $start_date;
        $record->end_date =  $end_date;

        $record->start_date1 = $data['start_date1'];
        $record->end_date1 =  $data['end_date1'];

        if ($data['address_type'] == "Self Pickup") {
            $delivery_charges = 0;
        } else {
            $delivery_charges = $data['distance_amount'];
        }

        $getPrice = $this->PriceListModel->where('category_id', $bike->category_id)->first();

        if (!isset($data['advance_amount']))
            $data['advance_amount'] = $getPrice->deposit;


        $total_charges = $data['charges'] + $delivery_charges + $data['advance_amount'];
        $gst = (($data['charges'] + $delivery_charges) * 5) / 100;

        if ($data['payment_type'] == 'Cash on Center') {
            $payment_type = 1;
        } else {
            $payment_type = 2;
        }

        $record->address_type =  $data['address_type'] ?? $record['address_type'];
        $record->address =  $data['address'] ?? null;
        $record->charges =  $data['charges'] ?? $record['charges'];
        $record->advance_amount =  $data['advance_amount'] ?? $record['advance_amount'];
        $record->delivery_charges =  $delivery_charges;
        $record->total_charges =  $total_charges;
        $record->delivery_type =  $data['delivery_type'] ?? null;
        $record->gst = $gst;
        $record->final_amount = ($total_charges) + $gst;

        $record->additional_charges =  $data['additional_charges'] ?? $record['additional_charges'];
        $record->additional_hours =  $data['additional_hours'] ?? $record['additional_hours'];
        $record->total_hours = round((strtotime($end_date) - strtotime($start_date)) / 3600, 1);
        $record->customer_id =  $data['user_id'];
        $record->km =  $data['distance'] ?? null;
        $record->payment_type = $payment_type ?? null;
        $record->transaction_id = $data['transaction_id'] ?? null;


        if (isset($data['coupon_id'])) {
            $offer = $this->OfferModel->find($data['coupon_id']);
            if ($offer) {
                $record->coupon_id = $data['coupon_id'] ?? null;
                $record->coupon_code = $offer->offer_code ?? null;
                // if($offer->discount_type=='percentage')
                //     $amt = $data['charges'] * $offer->discount_value/100;
                // else
                //     $amt = $offer->discount_value;
                $record->coupon_amount = $data['coupon_amount'] ?? 0;
            }
        }

        $record->save();

        $user = [];
        $user_exists = $this->UserModel->find($data['user_id']);
        $bike_exists = $this->BikeModel->find($data['vehicle_id']);

        $user['contact_number'] = $user_exists->contact_number ?? 0;
        $user['vehicle_number'] = $bike_exists->registration_number ?? 0;
        $user['start_date'] = date('Y-m-d', strtotime($data['start_date']));
        $user['end_date'] = date('Y-m-d', strtotime($data['end_date']));

        $dealer = $this->UserModel->find($bike_exists->dealer_id);
        if ($dealer->firebase_token != null) {
            $ids = explode(",", $dealer->firebase_token);
            foreach ($ids as $id) {
                $this->sendNotification($id, $user_exists, $user['vehicle_number'], $record);
            }
        }

        $this->sendBookingConfirmation($user);

        return $record;
    }


    public function sendNotification($token, $user, $vehicle_number, $booking)
    {
        // dd($token);
        $url = "https://fcm.googleapis.com/fcm/send";

        $fields = array(
            "to" => $token,
            "notification" => array(
                "body" => "New Booking requested for vehicle " . $vehicle_number,
                "title" => "New Booking",
                "icon" => "https://uat.vegobike.in/assets/pictures/app_logo.png",
                "click_action" => "" . url('bookings/edit') . "/" . $booking->id
            )
        );



        $headers = array(
            'Authorization: key=AAAAmY6h4T4:APA91bEWkf72i7DiqUoXuC8w6a3suqutZJmtDWaOA7W3qA9l_6ACcj-fmI4hmXZehBy9KUyfJTcIoqzPHsmwf3uqz41Nq0EDvrbYk_hra1o_Jm1DjIQsGQih-WIbQuqDTxfbggjTd4Xn',
            'Content-Type:application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        // print_r($result);
        curl_close($ch);
    }

    public function sendBookingConfirmation($data)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://control.msg91.com/api/v5/flow/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
                'template_id' => '64feb072d6fc0522983ccee3',
                'recipients' => [
                    [
                        'mobiles' => '91' . $data['contact_number'], // customer mobile number
                        'var1' => $data['vehicle_number'], // vehicle number
                        'var2' => $data['start_date'], // start date
                        'var3' => $data['end_date'] // end date
                    ]
                ]
            ]),
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "authkey: 404975ADKNeF6q4btb64f36c23P1",
                "content-type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            // echo "cURL Error #:" . $err;
        } else {
            // echo $response;
        }
    }

    public function getBooking($data)
    {
        $record = $this->BookingRequestModel
            ->join('booking_statuses', 'booking_statuses.id', 'booking_requests.booking_status')
            ->join('users', 'users.id', 'booking_requests.customer_id')
            ->where('booking_requests.customer_id', $data['user_id'])->with(['before_images', 'after_images', 'bike_details'])
            ->orderBy('booking_requests.created_at', 'DESC')
            ->select('booking_requests.*', 'booking_statuses.name as booking_status_name', 'booking_statuses.color_code as booking_color_code', 'users.name', 'users.contact_number');
        if (isset($data['dashboard'])) {
            $record = $record->limit(1);
        }
        $record = $record->get();
        return $record;
    }

    public function getBookingDetails($data = [])
    {
        return $this->BookingRequestModel
            ->join('booking_statuses', 'booking_statuses.id', 'booking_requests.booking_status')
            ->join('bikes', 'bikes.id', 'booking_requests.vehicle_id')
            ->join('brands', 'brands.id', 'bikes.brand_id')
            ->join('models', 'models.id', 'bikes.model_id')
            ->join('users', 'users.id', 'booking_requests.customer_id')
            ->where('booking_requests.customer_id', $data['user_id'])
            ->where('booking_requests.id', $data['booking_id'])
            ->with(['before_images', 'after_images', 'bike_details'])
            ->orderBy('booking_requests.created_at', 'DESC')
            ->select('booking_requests.*', 'booking_statuses.name as booking_status_name', 'booking_statuses.color_code as booking_color_code', 'brands.brand_name', 'models.model_name', 'users.name', 'users.contact_number')
            ->first();
    }

    public function getLocationDetails($data = [])
    {
        return $this->StoreModel->where('is_active', 1)->get();
    }

    public function getAmountDetails($data = [])
    {
        $diff = strtotime(substr($data['end_date'], 0, 10)) - strtotime(substr($data['start_date'], 0, 10));
        $additional_diff = strtotime($data['end_date']) - strtotime($data['start_date']);
        $total_hours = floor($diff / (60 * 60));
        
        $additional_hours = floor($additional_diff / (60 * 60));
        $additional_hours = ($additional_hours - 1) - $total_hours;
        if($additional_hours<=0)
        $additional_hours = 0;

       
        
        $days = intval($total_hours / 24);

        if ($days == 0) {
            $days = 1;
        } else {
            $days = $days + 0;
        }
        //$fullMinutes = floor(($diff-($total_hours*60*60))/60);
        //$fullSeconds = floor($diff-($total_hours*60*60)-($fullMinutes*60));

        if ($days > 0 && $days < 7) {
            $price_list = $this->PriceListModel->where('category_id', $data['category_id'])->where('days', 1)->first();
            $total_price = $days * $price_list->price;
            $advance_payment = $price_list->deposit;
        } else if ($days > 6 && $days <= 14) {
            $price_list = $this->PriceListModel->where('category_id', $data['category_id'])->where('days', 7)->first();
            $price_list_one = $this->PriceListModel->where('category_id', $data['category_id'])->where('days', 1)->first();
            if ($days == 7) {

                $total_price = 0 + $price_list->price;
                $advance_payment = $price_list->deposit;
            } else if ($days == 14) {

                $total_price = 2 * $price_list->price;
                $advance_payment = $price_list->deposit;
            } else {
                $total_price = $price_list->price + ($days - 7) * $price_list_one->price;
                $advance_payment = $price_list->deposit;
            }
        } else if ($days > 14 && $days < 30) {
            $price_list = $this->PriceListModel->where('category_id', $data['category_id'])->where('days', 15)->first();
            $price_list_seven = $this->PriceListModel->where('category_id', $data['category_id'])->where('days', 7)->first();
            $price_list_one = $this->PriceListModel->where('category_id', $data['category_id'])->where('days', 1)->first();

            if ($days == 15) {
                $total_price = $price_list->price;
                $advance_payment = $price_list->deposit;
            } else if ($days == 22) {
                $total_price =  $price_list_seven->price + $price_list->price;
                $advance_payment = $price_list_seven->deposit;
            } else if ($days == 29) {
                $total_price =  $price_list->price + ($price_list_seven->price * 2);
                $advance_payment = $price_list_seven->deposit;
            } else {
                $total_price = $price_list->price + $price_list_one->price * ($days - 15);
                $advance_payment = $price_list->deposit;
            }
        } else if ($days == 0) {
            $price_list_one = $this->PriceListModel->where('category_id', $data['category_id'])->where('days', 1)->first();
            $total_price = 0 + $price_list_one->price;
            $advance_payment = $price_list_one->deposit;
        } else if ($days > 29) {
            $price_list = $this->PriceListModel->where('category_id', $data['category_id'])->where('days', 30)->first();
            $total_price = 0 + $price_list->price;
            $advance_payment = $price_list->deposit;
        }

        $hourly_price = $this->PriceListModel->where('category_id', $data['category_id'])->where('days', 0)->first();
        if($hourly_price)
        $total_price = $total_price + ($additional_hours * $hourly_price->price);

        return [
            'advance_payment' => $advance_payment,
            'total_hours' => $total_hours,
            'total_days' => $days,
            'total_amount' => $total_price
        ];
    }

    public function getKmDetails($data = [])
    {
        $bike = $this->BikeModel->where('bikes.id', $data['vehicle_id'])->join('stores', 'stores.id', 'bikes.store_id')->select('stores.store_latitude', 'stores.store_longitude')->first();
        $latitude1 = $data['latitude'];
        $longitude1 = $data['longitude'];
        $latitude2 = $bike->store_latitude;
        $longitude2 = $bike->store_longitude;

        $longi1 = deg2rad($longitude1);
        $longi2 = deg2rad($longitude2);
        $lati1 = deg2rad($latitude1);
        $lati2 = deg2rad($latitude2);

        $difflong = $longi2 - $longi1;
        $difflat = $lati2 - $lati1;

        $val = pow(sin($difflat / 2), 2) + cos($lati1) * cos($lati2) * pow(sin($difflong / 2), 2);

        $res2 = 6378.8 * (2 * asin(sqrt($val))); //for kilometers

        $default = $this->LocationPriceListModel->where('is_active', 1)->where('is_default', 1)->orderBy('km', 'ASC')->first();
        $rem = $res2 - $default->km;
        $rem_default = $this->LocationPriceListModel->where('is_active', 1)->where('is_default', 0)->orderBy('km', 'ASC')->first();
        if ($res2 <= $default->km) {
            if (isset($data['delivery_type']) && $data['delivery_type'] == 'delivery_pickup')
                $default_price = $default->price * 2;
            else
                $default_price = $default->price;
        } else {
            if (isset($data['delivery_type']) && $data['delivery_type'] == 'delivery_pickup')
                $default_price = (round($res2) * $rem_default->price) * 2;
            else
                $default_price = round($res2) * $rem_default->price;
        }

        return [
            'distance' => round($res2),
            'distance_amount' => $default_price
        ];
    }

    public function getStatus()
    {
        return $this->BookingStatusModel->get();
    }

    public function updateStatus($data = [])
    {
        $record = $this->BookingRequestModel->where('id', $data['booking_id'])->first();
        if ($record) {
            $record->booking_status = $data['status'];
            $record->save();
            return $record;
        }
        return null;
    }

    public function applyCode($data = [])
    {
        date_default_timezone_set("Asia/Kolkata");
        $current_date = date('Y-m-d H:i:s');
        $record = $this->OfferModel
            ->where('offer_code', $data['coupon_code'])
            ->where('is_active', 1)
            ->where('start_date', '<', $current_date)
            ->where('end_date', '>', $current_date)
            ->first();


        if ($record) {

            $check_existing_booking = $this->BookingRequestModel->where('customer_id',$data['user_id'])->where('coupon_id',$record->id)->first();
            if($record->applies_to=="first" && $check_existing_booking)
            {
                return response()->json(['status' => false, 'message' => 'Code valid for first order only']);
            }
            if($record->limit2==0 && $check_existing_booking)
            {
                return response()->json(['status' => false, 'message' => 'Invalid coupon code']);
            }

            if ($record->eligibility=="specific_customer") {
                if (!in_array($data['user_id'], json_decode($record->customer_ids, true))) {
                    return response()->json(['status' => false, 'message' => 'Invalid coupon code']);
                }
            }

            if ($data['amount'] <= $record->minimum_amount) {
                return response()->json(['status' => false, 'message' => 'Minimum amount should be greater than ₹' . $record->minimum_amount]);
            }
            return response()->json(['status' => true, 'message' => 'Coupon code applied successfully', 'coupon_details' => $record]);
        } else {
            return response()->json(['status' => false, 'message' => 'Invalid coupon code']);
        }
    }
}
