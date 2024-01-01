<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\User;
use App\Models\BookingRequest;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Store;
use App\Models\BookingStatus;

class ReportController extends Controller
{
    public function getAllRegisteredUsers(Request $request)
    {
    	if($request->ajax())
    	{
    		$data = User::where('role_id','3');
    		if($request->name!=null)
    		{
    			$data = $data->where(function($query) use($request){
    				$query->where('name','like','%'.$request->name.'%')
    				->orWhere('contact_number','like','%'.$request->name.'%')
    				->orWhere('email','like','%'.$request->name.'%');
    			});
    		}
    		if($request->from_date!=null && $request->to_date!=null)
    		{
    			$data = $data->whereDate('created_at','>=',$request->from_date)->whereDate('created_at','<=',$request->to_date);
    		}
    		if($request->from_date!=null && $request->to_date==null)
    		{
    			$data = $data->whereDate('created_at',$request->from_date);
    		}
    		if($request->from_date==null && $request->to_date!=null)
    		{
    			$data = $data->whereDate('created_at',$request->to_date);
    		}
    		if($request->status!="null")
    		{
    			$data = $data->where('is_active',$request->status);
    		}
    		$data = $data->orderBy('created_at','ASC');
    		return DataTables::of($data)
    		->addColumn('register_date',function($record){
    			return date('d-m-Y',strtotime($record->created_at));
    		})
    		->rawColumns(['register_date'])
    		->make(true);
    	}
    	return view('reports.all-customers');
    }

    public function getAllFinancialReports(Request $request)
    {
    	if($request->ajax())
    	{
    		$data = BookingRequest::where('booking_requests.booking_status',6)
    		->leftJoin('users','users.id','booking_requests.customer_id')
    		->leftJoin('bikes','bikes.id','booking_requests.vehicle_id')
    		->join('invoices','invoices.booking_id','booking_requests.id');

    		if($request->from_date!=null && $request->to_date!=null)
    		{
    			$data = $data->whereDate('invoices.created_at','>=',$request->from_date)->whereDate('invoices.created_at','<=',$request->to_date);
    		}
    		if($request->from_date!=null && $request->to_date==null)
    		{
    			$data = $data->whereDate('invoices.created_at','>=',$request->from_date);
    		}
    		if($request->from_date==null && $request->to_date!=null)
    		{
    			$data = $data->whereDate('invoices.created_at',$request->to_date);
    		}
    // 		if($request->type!="null")
    // 		{
    // 			$data = $data->where('booking_requests.address_type',$request->type);
    // 		}
    // 		if($request->category_id!="null")
    // 		{
    // 			$data = $data->where('bikes.category_id',$request->category_id);
    // 		}
    // 		if($request->brand_id!="null")
    // 		{
    // 			$data = $data->where('bikes.brand_id',$request->brand_id);
    // 		}

    		$data = $data->orderBy('invoices.invoice_id','DESC')->select('booking_requests.*','users.name','users.contact_number','invoices.invoice_id','invoices.created_at as invoice_date');
    		return DataTables::of($data)
    		->addColumn('invoice_date',function($record){
    			return date('d-m-Y',strtotime($record->invoice_date));
    		})
    		->addColumn('taxable_amount',function($record){
    			return $record->charges + $record->delivery_charges + $record->additional_charges;
    		})
    		->addColumn('cgst',function($record){
    			return $record->gst/2;
    		})
    		->rawColumns(['invoice_date','taxable_amount','cgst'])
    		->make(true);
    	}

    	$categories = Category::where('is_active',1)->orderBy('category_name','ASC')->get();
    	$brands = Brand::where('is_active',1)->orderBy('brand_name','ASC')->get();
    	$stores = Store::where('is_active',1)->orderBy('store_name','ASC')->get();
    	return view('reports.all-financial-reports',compact('categories','brands','stores'));
    }

    public function getAllCancellationReports(Request $request)
    {
    	if($request->ajax())
    	{
    		$data = BookingRequest::where('booking_requests.booking_status',6)
    		->leftJoin('users','users.id','booking_requests.customer_id')
    		->leftJoin('bikes','bikes.id','booking_requests.vehicle_id')
    		->leftJoin('invoices','invoices.booking_id','booking_requests.id');
    

    		if($request->from_date!=null && $request->to_date!=null)
    		{
    			$data = $data->whereDate('booking_requests.created_at','>=',$request->from_date)->whereDate('booking_requests.created_at','<=',$request->to_date);
    		}
    		if($request->from_date!=null && $request->to_date==null)
    		{
    			$data = $data->whereDate('booking_requests.created_at','>=',$request->from_date);
    		}
    		if($request->from_date==null && $request->to_date!=null)
    		{
    			$data = $data->whereDate('booking_requests.created_at',$request->to_date);
    		}
    // 		if($request->type!="null")
    // 		{
    // 			$data = $data->where('booking_requests.address_type',$request->type);
    // 		}
    // 		if($request->category_id!="null")
    // 		{
    // 			$data = $data->where('bikes.category_id',$request->category_id);
    // 		}
    // 		if($request->brand_id!="null")
    // 		{
    // 			$data = $data->where('bikes.brand_id',$request->brand_id);
    // 		}

    		$data = $data->orderBy('booking_requests.created_at','DESC')->select('booking_requests.*','users.name','users.contact_number','invoices.invoice_id');
    		return DataTables::of($data)
    		->addColumn('booking_date',function($record){
    			return date('d-m-Y',strtotime($record->created_at));
    		})
    		->addColumn('bike',function($record){
    			return $record->brand_name." ".$record->model_name;
    		})
    		->addColumn('invoice_id',function($record){
    			return $record->invoice_id ?? '-';
    		})
    		->rawColumns(['booking_date','bike','invoice_id'])
    		->make(true);
    	}

    	$categories = Category::where('is_active',1)->orderBy('category_name','ASC')->get();
    	$brands = Brand::where('is_active',1)->orderBy('brand_name','ASC')->get();
    	$stores = Store::where('is_active',1)->orderBy('store_name','ASC')->get();
    	return view('reports.all-cancellation-reports',compact('categories','brands','stores'));
    }

    public function getAllBookingReports(Request $request)
    {
    	if($request->ajax())
    	{
    		$data = BookingRequest::leftJoin('users','users.id','booking_requests.customer_id')
    		->leftJoin('bikes','bikes.id','booking_requests.vehicle_id')
    		->leftJoin('categories','categories.id','bikes.category_id')
    		->leftJoin('brands','brands.id','bikes.brand_id')
    		->leftJoin('models','models.id','bikes.model_id')
    		->leftJoin('stores','stores.id','bikes.store_id')
    		->leftJoin('booking_statuses','booking_statuses.id','booking_requests.booking_status');

    		if($request->from_date!=null && $request->to_date!=null)
    		{
    			$data = $data->whereDate('booking_requests.created_at','>=',$request->from_date)->whereDate('booking_requests.created_at','<=',$request->to_date);
    		}
    		if($request->from_date!=null && $request->to_date==null)
    		{
    			$data = $data->whereDate('booking_requests.created_at',$request->from_date);
    		}
    		if($request->from_date==null && $request->to_date!=null)
    		{
    			$data = $data->whereDate('booking_requests.created_at',$request->to_date);
    		}
    		
    		if($request->category_id!="null")
    		{
    			$data = $data->where('bikes.category_id',$request->category_id);
    		}
    		

    		$data = $data->orderBy('booking_requests.created_at','ASC')->select('booking_requests.*','users.name','users.contact_number','categories.category_name','brands.brand_name','models.model_name','stores.store_name','booking_statuses.color_code','booking_statuses.name as status_name','bikes.registration_number');
    		return DataTables::of($data)
    		->addColumn('booking_date',function($record){
    			return date('d-m-Y',strtotime($record->created_at));
    		})
    		->addColumn('bike',function($record){
    			return $record->brand_name." ".$record->model_name;
    		})
    		->addColumn('amount',function($record){
    			return $record->charges + $record->additional_charges;
    		})
    		->addColumn('status_name',function($record){
    			return '<span class="badge badge-sm badge-dot has-bg d-none d-sm-inline-flex" style="color:'.$record->color_code.'">'.$record->status_name.'</span>';
    		})
    		->rawColumns(['booking_date','bike','status_name','amount'])
    		->make(true);
    	}

    	$categories = Category::where('is_active',1)->orderBy('category_name','ASC')->get();
    	$brands = Brand::where('is_active',1)->orderBy('brand_name','ASC')->get();
    	$stores = Store::where('is_active',1)->orderBy('store_name','ASC')->get();
    	$statuses = BookingStatus::orderBy('id','ASC')->get();
    	return view('reports.all-booking-reports',compact('categories','brands','stores','statuses'));
    }
}
