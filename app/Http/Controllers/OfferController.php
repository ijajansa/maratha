<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Services\OfferService;
use Hash;
use App\Models\User;
use Illuminate\Validation\Rule;


class OfferController extends Controller
{
    protected  $OfferService;
    public function __construct()
    {
        $this->OfferService = new OfferService();
    }
    
    public function getAllOffers(Request $request)
    {
    	if($request->ajax())
    	{
    		$data = $this->OfferService->fetch();
    		return DataTables::of($data)->
    		addColumn('offer_image',function($row){
    			if($row->offer_image!=null)
    			{
    				return "<a href='".url('storage/app')."/".$row->offer_image."'><img src='".url('storage/app')."/".$row->offer_image."' width='100px'>";
    			}
    			else
    			{
    				return "<img src='".asset('assets/images/default.svg')."' width='45px' height='45px'>";
    			}
    		})
    		->rawColumns(['offer_image'])->make(true);
    	}
    	return view('offers.all');
    }

    public function getAddOffer()
    {
        $customers = User::where('is_active',1)->where('role_id',3)->orderBy('name','ASC')->get();
        return view('offers.add',compact('customers'));
    }

    public function addOffer(Request $request)
    {
    	$request->validate([
            'offer_name' => 'required',
            'offer_code' => 'required',
            'discount_type' => 'required',
            'discount_value' => 'required|numeric',
            'applies_to' => 'required',
            'minimum_amount' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'eligibility' => 'required',
            'customer_ids' => 'required_if:eligibility,==,specific_customer',
            'usage_limit' => 'required'
        ]);

    	$record = $request->all();
        unset($record['_token']);
        $response = $this->OfferService->create($record);
        if($response)
        {
        	return redirect('offers/all')->with('success','Offers added successfully');
        }
        return redirect('offers/all')->with('error','Something went wrong');
    }

    public function changeStatus($id)
    {
        $response = $this->OfferService->changeStatus($id);
        if($response)
        {
            return redirect()->back()->with('success','Offer status changed successfully');
        }
        else
        {
            return redirect()->back()->with('error','Unable to change offer record');
        }  
    }

    public function deleteOffer($id)
    {
    	$response = $this->OfferService->delete($id);
        if($response)
        {
            return redirect()->back()->with('success','Offer deleted successfully');
        }
        else
        {
            return redirect()->back()->with('error','Unable to delete offer');
        }  
    }

    public function editOfferPage($id)
    {
    	$record = $this->OfferService->fetchSingle($id);
    	if($record)
    	{
            $ids = json_decode($record->customer_ids,true);
            $customers = User::where('is_active',1)->where('role_id',3)->orderBy('name','ASC')->get(['id','name']);
            foreach($customers as $customer){
                $customer['is_present'] = 0;
                if($ids)
                {
                  
                    if(in_array($customer->id, $ids))
                    {
                        $customer['is_present'] = 1;
                    }  
                }    
            }

            return view('offers.edit',compact('record','customers'));
        }
        return redirect()->back('error','Offer detail not found');
    }

    public function postUpdateOffer(Request $request)
    {
    	$request->validate([
    		'offer_name' => 'required',
            'offer_code' => 'required',
            'discount_type' => 'required',
            'discount_value' => 'required|numeric',
            'applies_to' => 'required',
            'minimum_amount' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'eligibility' => 'required',
            'customer_ids' => 'required_if:eligibility,==,specific_customer',
            'usage_limit' => 'required'
        ]);

    	$record = $request->all();
    	$record['id'] = $request->id ?? 0;
        unset($record['_token']);
        $response = $this->OfferService->update($record);
        if($response)
        {
        	return redirect('offers/all')->with('success','Offer details updated successfully');
        }
        return redirect('offers/all')->with('error','Something went wrong');

    }

}
