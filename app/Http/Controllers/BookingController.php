<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\LocationMaster;
use App\Models\BookingRequest;
use App\Models\BookingStatus;
use App\Models\BookingBike;
use App\Models\UserDocument;
use App\Models\Invoice;
use Hash;
use Auth;

class BookingController extends Controller
{
	public function editBooking(Request $request)
	{
		$request->validate([
			'address' => 'required',
			'latitude' => 'required',
			'longitude' => 'required',
		]);

		$data = LocationMaster::find($request->id);
		$data->address = $request->address;
		$data->latitude = $request->latitude;
		$data->longitude = $request->longitude;
		$data->save();
		return redirect('bookings/all')->with('success','Self pickup location updated successfully');
	}

	public function editBookingPage($id)
	{
		$data = BookingRequest::where('id',$id)->with('bike_details')->first();
		if($data)
		{
			$images  = BookingBike::where('booking_id',$data->id)->get();
			$documents  = UserDocument::where('user_id',$data->customer_id)->first();
			$statuses = BookingStatus::all(); 
			return view('bookings.edit',compact('data','images','documents','statuses'));
		}
		return redirect()->back()->with('error','Booking details not found');
	}

	public function getAllBooking(Request $request)
	{
		if($request->ajax())
		{
			$data = BookingRequest::with('bike_details')
			->leftJoin('users','users.id','booking_requests.customer_id')
			->leftJoin('bikes','bikes.id','booking_requests.vehicle_id');
			if(Auth::user()->role_id != 1)
			{
			    $data = $data->where('bikes.store_id',Auth::user()->store_id);
			}
			if($request->address_type!=null)
			{
			    $data = $data->where('booking_requests.address_type',$request->address_type);
			}
			if($request->date!=null)
			{
			    $data = $data->whereDate('booking_requests.created_at',$request->date);
			}
			if($request->status!=null)
			{
			    if($request->status == 6)
			    $data = $data->where('booking_requests.booking_status',$request->status);
			    else if($request->status==8)
			    $data = $data->whereNotIn('booking_requests.booking_status',[1,2,3,4,6,7]);
			    else if($request->status == 2)
			    $data = $data->whereNotIn('booking_requests.booking_status',[6,7]);
			}
			if($request->search_record!=null)
			{
			    $data = $data->where(function($query) use ($request){
			        $query->where('booking_requests.booking_id','like','%'.$request->search_record.'%')
			        ->orWhere('users.name','like','%'.$request->search_record.'%')
			        ->orWhere('bikes.registration_number','like','%'.$request->search_record.'%')
			        ->orWhere('users.contact_number','like','%'.$request->search_record.'%');
			    });
			}
			$data = $data->select('booking_requests.*','users.name as customer_name','users.contact_number as customer_number')
			->orderBy('booking_requests.id','DESC');
			return DataTables::of($data)
			->addColumn('formated_start_date',function ($data){
				return date('d-m-Y h:i A',strtotime($data->start_date));
        })->addColumn('formated_end_date',function ($data){
				return date('d-m-Y h:i A',strtotime($data->end_date));
        })
        ->addColumn('created_date',function ($data){
				return date('d-m-Y',strtotime($data->created_at));
        })
        ->rawColumns(['formated_start_date','formated_end_date','created_date'])
        ->make(true);
		}
		return view('bookings.all');
	}

	public function getInvoice(Request $request)
	{
	    $data = BookingRequest::leftJoin('users','users.id','booking_requests.customer_id')
    		->leftJoin('bikes','bikes.id','booking_requests.vehicle_id')
    		->leftJoin('categories','categories.id','bikes.category_id')
    		->leftJoin('brands','brands.id','bikes.brand_id')
    		->leftJoin('models','models.id','bikes.model_id')
    		->leftJoin('stores','stores.id','bikes.store_id')
    		->join('invoices','invoices.booking_id','booking_requests.id')
    		->leftJoin('booking_statuses','booking_statuses.id','booking_requests.booking_status');

    		$data = $data->select('booking_requests.*','users.name','users.contact_number','categories.category_name','brands.brand_name','models.model_name','stores.store_name','booking_statuses.color_code','booking_statuses.name as status_name','bikes.registration_number','booking_requests.address','invoices.invoice_id',\DB::raw("DATE_FORMAT(invoices.created_at, '%d-%b-%Y') as formatted_date"))->where('booking_requests.id',$request->id)->first();
	    if($data)
	    {
	        if(isset($request->mobile) && $request->mobile == true)
	        {
	            return view('auth.invoice',compact('data'));
	        }
	        else
	        {
	            return view('bookings.add',compact('data'));
	        }
	    }
	    return redirect()->back()->with('error','Record not found');
	}
	public function addBooking(Request $request)
	{
		$request->validate([
			'address' => 'required',
			'latitude' => 'required',
			'longitude' => 'required',
		]);

		$data = new LocationMaster();
		$data->address = $request->address;
		$data->latitude = $request->latitude;
		$data->longitude = $request->longitude;
		$data->save();
		return redirect('bookings/all')->with('success','Self pickup location added successfully');
	}

	public function deleteBooking($id)
	{
		$data = Store::find($id);
		if($data)
		{
			$data->is_active = 0;
			$data->save();
			return redirect()->back()->with('success','Store deleted successfully');		
		}
		else
		{
			return redirect()->back()->with('error','Unable to delete store');		
		}
	}

	public function changeStatus(Request $request)
	{

		$response = BookingRequest::find($request->id);
		if($response)
		{
		    if($response->booking_status == 6)
		    {
		        return redirect()->back()->with('success','Cannot update booking status if its already completed');
		    }
			if(isset($request->additional_charges))
			{
				$response->additional_charges = $request->additional_charges;
				$amt = $response->charges + $request->additional_charges;
				$response->gst = $amt * 0.05; 
				$response->final_amount = $response->total_charges + $amt * 0.05; 
				$response->additional_charges_details = $request->additional_charges_details;
			}
			$response->booking_status = $request->booking_status;
			$response->save();
			
			if($response->booking_status == 6)
			{
			    $booking_count = Invoice::count();
                if($booking_count == 0)
                {
                    $booking_id_count = "VB00".$booking_count+1;
                }
                else if($booking_count < 10)
                {
                    $booking_id_count = "VB00".$booking_count+1;
                }
                else if($booking_count >= 10 && $booking_count < 100)
                {
                    $booking_id_count = "VB0".$booking_count+1;
                }
                else if($booking_count >= 100 && $booking_count < 1000)
                {
                    $booking_id_count = "VB".$booking_count+1;
                }
			    
			    $invoice = new Invoice();
			    $invoice->booking_id = $response->id ?? 0;
			    $invoice->invoice_id = $booking_id_count;
			    $invoice->save();
			    
			}
			
			return redirect()->back()->with('success','Booking status updated successfully');
		}
		else
		{
			return redirect()->back()->with('error','Unable to change status');
		}  
	}
}
