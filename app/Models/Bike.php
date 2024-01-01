<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bike extends Model
{
    use HasFactory;

    protected $fillable = ['category_id','store_id','brand_id','model_id','registration_number','registration_year_id','chassis_number','engine_number','is_puc','puc_image','insurance_image','document_image','is_insurance','is_documents','dealer_id','latitude','longitude'];
    
    public function bike_images()
    {
        return $this->hasMany('App\Models\BikeImages','bike_id','id');
    }
    
    public function price_lists()
    {
        return $this->hasMany('App\Models\PriceList','category_id','category_id')->where('days','!=',0);
    }
    
    public function single_price()
    {
        return $this->hasOne('App\Models\PriceList','category_id','category_id')->where('days',1);
    }
}
