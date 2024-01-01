<?php
namespace App\Services;
use App\Models\Bike;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Modal;
use App\Models\BookingRequest;
use Storage;

class VehicleService
{
	protected $BikeModel;
    protected $CategoryModel;
    protected $BrandModel;
	protected $ModelModel;
	protected $BookingRequestModel;
    public function __construct()
    {
    	$this->BikeModel = new Bike();
        $this->CategoryModel = new Category();
        $this->BrandModel = new Brand();
    	$this->ModelModel = new Modal();
    	$this->BookingRequestModel = new BookingRequest();
    }

    public function getFilteredVehicles($data = [])
    {
        $data['latitude']  = $data['latitude'] ?? null;
        $data['longitude']  = $data['longitude'] ?? null;
        if($data['latitude']==null)
        {
            return $this->BikeModel->with('bike_images:id,bike_id,images')->with('price_lists')
            ->join('years','years.id','bikes.registration_year_id')
            ->join('brands','brands.id','bikes.brand_id')
            ->join('models','models.id','bikes.model_id')
            ->join('categories','categories.id','bikes.category_id')
            ->where('bikes.is_active',1)
            ->take(20)
            ->select("bikes.*","years.year","brands.brand_name","models.model_name","categories.category_name")
            ->get();
        }
        else
        {
            $bikes = $this->BikeModel->with('bike_images:id,bike_id,images')->with('price_lists')->selectRaw("bikes.*")->selectRaw("
                         ( 6371 * acos( cos( radians(?) ) *
                           cos( radians( latitude ) )
                           * cos( radians( longitude ) - radians(?)
                           ) + sin( radians(?) ) *
                           sin( radians( latitude ) ) )
                         ) AS distance", [$data['latitude'], $data['longitude'], $data['latitude']])
            ->where('bikes.is_active', 1)
            ->having("distance", "<", 20)
            ->orderBy("distance",'asc')
            ->join('years','years.id','bikes.registration_year_id')
            ->join('brands','brands.id','bikes.brand_id')
            ->join('models','models.id','bikes.model_id')
            ->join('categories','categories.id','bikes.category_id')
            ->selectRaw("years.year")
            ->selectRaw("brands.brand_name")
            ->selectRaw("models.model_name")
            ->selectRaw("categories.category_name")
            ->get();
        }
        
            
            return $bikes;
    }
    
    public function get($data =[])
    {
        $data['start_date'] = date('Y-m-d',strtotime($data['start_date']));
        $data['end_date'] = date('Y-m-d',strtotime($data['end_date']));
        $vehicle_id = $data['vehicle_id'] ?? 0;
        $vehicle =  $this->BikeModel->with('bike_images:id,bike_id,images')
        ->with('price_lists')
        ->join('years','years.id','bikes.registration_year_id')
        ->join('brands','brands.id','bikes.brand_id')
        ->join('models','models.id','bikes.model_id')
        ->join('categories','categories.id','bikes.category_id')
        ->join('stores','bikes.store_id','stores.id')
        ->select("bikes.*","years.year","brands.brand_name","models.model_name","categories.category_name","stores.store_address as default_address","stores.store_url","stores.store_contact_number","stores.store_latitude","stores.store_longitude")
        ->where('bikes.id',$vehicle_id)->first();
        if($vehicle)
        {
                $vehicle->is_available = 0;
                $check = $this->BookingRequestModel->where('vehicle_id',$vehicle->id)->where('start_date1','<=',$data['start_date'])->orderBy('start_date1','DESC')->first();
                if($check)
                {
                    if($check->end_date1 <= $data['start_date'])
                    {
                            $vehicle->is_available = 1;
                    }
                    else
                    {
                        if($check->booking_status == 4 || $check->booking_status == 6 || $check->booking_status == 8)
                        {
                            $vehicle->is_available = 1;
                        }
                        else
                        {
                            return false;
                        }
                    }
                    
                }
                else
                {
                    $vehicle->is_available = 1;
                }
        }
        
        return $vehicle;
        
    }
    
    public function getVehicles($data =[])
    {
        $data['start_date'] = date('Y-m-d',strtotime($data['start_date']));
        $data['end_date'] = date('Y-m-d',strtotime($data['end_date']));
        
        
        
        // $bikes = $this->BikeModel->with('bike_images:id,bike_id,images')->with('price_lists')->selectRaw("bikes.*")->selectRaw("price_lists.price")->selectRaw("
        //                  ( 6371 * acos( cos( radians(?) ) *
        //                   cos( radians( latitude ) )
        //                   * cos( radians( longitude ) - radians(?)
        //                   ) + sin( radians(?) ) *
        //                   sin( radians( latitude ) ) )
        //                  ) AS distance", [$data['latitude'], $data['longitude'], $data['latitude']])
        //     ->where('bikes.is_active', 1)
        //     ->having("distance", "<", 10)
        //     ->join('years','years.id','bikes.registration_year_id')
        //     ->join('brands','brands.id','bikes.brand_id')
        //     ->join('models','models.id','bikes.model_id')
        //     ->join('categories','categories.id','bikes.category_id')
        //     ->join('price_lists','bikes.category_id','price_lists.category_id')
        //     ->where('price_lists.days',7);
        
            $bikes = $this->BikeModel->with('bike_images:id,bike_id,images')->with(['price_lists'])->selectRaw("bikes.*")
            ->where('bikes.is_active', 1)
            ->join('years','years.id','bikes.registration_year_id')
            ->join('brands','brands.id','bikes.brand_id')
            ->join('models','models.id','bikes.model_id')
            ->join('categories','categories.id','bikes.category_id')
            // ->leftJoin('price_lists', function ($join) {
            //     $join->on('price_lists.category_id', '=', \DB::raw('(SELECT category_id FROM price_lists WHERE bikes.category_id = price_lists.category_id LIMIT 1)'));
            // })->selectRaw("price_lists.price as price")
            ->join('stores','bikes.store_id','stores.id')
            // ->whereIn('price_lists.days',[1,7])
            ;
            if(isset($data['address_type']) && $data['address_type'] == 1)
            {
                $bikes = $bikes->where('stores.store_latitude',$data['latitude'])->where('stores.store_longitude',$data['longitude']);
            }
            if(isset($data['category_id']))
            {
                $bikes = $bikes->where('bikes.category_id',$data['category_id']);
            }
            if(isset($data['brand_id']))
            {
                $bikes = $bikes->where('bikes.brand_id',$data['brand_id']);
            }
            if(isset($data['model_id']))
            {
                $bikes = $bikes->where('bikes.model_id',$data['model_id']);
            }
           
            $bikes = $bikes->selectRaw("years.year")
            ->selectRaw("brands.brand_name")
            ->selectRaw("models.model_name")
            ->selectRaw("categories.category_name")
            ->selectRaw("stores.store_address as default_address")
            ->selectRaw("stores.store_url")
            ->selectRaw("stores.store_contact_number");
            
            // if(isset($data['order_by']) && $data['order_by'] == 1)
            // {
            //     $bikes = $bikes->orderBy('price_lists.price', 'DESC');
            // }
            // else if(isset($data['order_by']) && $data['order_by'] == 2)
            // {
            //     $bikes = $bikes->orderBy('price_lists.price', 'ASC');
            // }
            $data_array = [];
            $bikes = $bikes->get();
            
            foreach($bikes as $bike)
            {
                $bike->is_available = 0;
                $check = $this->BookingRequestModel->where('vehicle_id',$bike->id)->where('start_date1','<=',$data['start_date'])->orderBy('start_date1','DESC')->first();
                if($check)
                {
                    if($check->end_date1 <= $data['start_date'])
                    {
                            $bike->is_available = 1;
                            array_push($data_array,$bike);
                    }
                    else
                    {
                        if($check->booking_status == 4 || $check->booking_status == 6 || $check->booking_status == 8)
                        {
                            $bike->is_available = 1;
                            array_push($data_array,$bike);
                        }
                    }
                    
                }
                else
                {
                    $bike->is_available = 1;
                    array_push($data_array,$bike);
                }
                // foreach($check as $record)
                // {
                //     if($record->start_date1 >= $data['start_date'] || $record->start_date1 <= $data['end_date'])
                //     {
                //         if($record->start_date1<= $data['end_date'] || $record->end_date1>= $data['end_date'])
                //         {
                        
                //             if($record->booking_status == 4 || $record->booking_status == 6)
                //             {
                //                 $bike->is_available = 1;
                //                 array_push($data_array,$bike);
                //             }
                //         }
                //     }
                // }
                // if($check)
                // {
                //     if($check->booking_status == 4 || $check->booking_status == 6)
                //     {
                //         $bike->is_available = 1;
                //         array_push($data_array,$bike);
                //     }
                // }
                // else
                // {
                //     $bike->is_available = 1;
                //     array_push($data_array,$bike);
                // }

            }
            
            return array_unique($data_array);
    }
    
    public function getAllCategories($data =[])
    {
        return $this->CategoryModel->where('is_active',1)->get();
    }
    public function getAllBrands($data =[])
    {
        $brands = $this->BrandModel;
        if(isset($data['category_id']))
        {
            $brands = $brands->where('category_id',$data['category_id']);
        }
        return $brands = $brands->where('is_active',1)->get();
    }
    public function getAllModels($data =[])
    {
        $models = $this->ModelModel;
        if(isset($data['brand_id']))
        {
            $models = $models->where('brand_id',$data['brand_id']);
        }
        return $models = $models->where('is_active',1)->get();
    }
    
}
