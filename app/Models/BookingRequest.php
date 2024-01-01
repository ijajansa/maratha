<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingRequest extends Model
{
    use HasFactory;

    public function before_images()
    {
    	return $this->hasMany('App\Models\BookingBike','booking_id','id')->where('type',1);
    }

    public function after_images()
    {
    	return $this->hasMany('App\Models\BookingBike','booking_id','id')->where('type',2);
    }
    
    public function bike_details()
    {
        return $this->belongsTo('App\Models\Bike','vehicle_id','id')
        ->leftJoin('brands','brands.id','bikes.brand_id')
        ->leftJoin('models','models.id','bikes.model_id')
        ->leftJoin('bike_images','bike_images.bike_id','bikes.id')
        ->leftJoin('stores','bikes.store_id','stores.id')
        ->select('bikes.*','brands.brand_name','models.model_name','bike_images.images as bike_image','stores.store_contact_number','stores.store_address','stores.store_url');
    }
    
    public function user_details()
    {
        return $this->belongsTo('App\Models\User','customer_id','id');
    }
    
    public function vehicles()
    {
        return $this->belongsTo('App\Models\Bike','vehicle_id','id');
    }
}
