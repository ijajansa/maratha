<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\LocationPriceList;
use Hash;


class LocationPriceController extends Controller
{
    public function getAllPricing(Request $request)
	{
		if($request->ajax())
		{
			$data = LocationPriceList::orderBy('km','ASC');
			return DataTables::of($data)->make(true);
		}
		return view('location-prices.all');
	}
	public function getAddPricing()
	{
		return view('location-prices.add');
	}
	public function addPricing(Request $request)
	{
		$request->validate([
			'km' => 'required|unique:location_price_lists,km',
			'amount' => 'required'
		],[
			'km.required' => 'The kilometer field is required.',
			'km.unique' => 'The kilometer has already been taken.',
		]);

		$data = new LocationPriceList();
		$data->km = $request->km;
		$data->price = $request->amount;
		$data->save();
		return redirect('location-prices/all')->with('success','Pricing added successfully');
	}

	public function editPricingPage($id)
	{
		$data = LocationPriceList::find($id);
		if($data)
		{
			return view('location-prices.edit',compact('data'));
		}
		return redirect()->back()->with('error','Pricing details not found');
	}

	public function editPricing(Request $request)
	{
		$request->validate([
			'km' => 'required|unique:location_price_lists,km,'.$request->id.'',
			'amount' => 'required'
		],[
			'km.required' => 'The kilometer field is required.',
			'km.unique' => 'The kilometer has already been taken.',
		]);

		$data = LocationPriceList::find($request->id);
		$data->km = $request->km;
		$data->price = $request->amount;
		$data->save();
		return redirect('location-prices/all')->with('success','Pricing details updated successfully');
	}

	public function changeStatus(Request $request)
	{

		$response = LocationPriceList::find($request->id);
		$response1 = LocationPriceList::get();
		foreach ($response1 as $key => $value) {
			$value->is_default = 0;
			$value->save();
		}
		if($response)
		{	
			$response->is_default = 1;
			$response->save();
			return redirect()->back()->with('success','Pricing status updated successfully');
		}
		else
		{
			return redirect()->back()->with('error','Unable to change status');
		}  
	}
	public function deletePricing($id)
	{
		$response = LocationPriceList::find($id);
		if($response)
		{
			$response->delete();
		}
			return redirect()->back()->with('success','Pricing deleted successfully');

	}
}
