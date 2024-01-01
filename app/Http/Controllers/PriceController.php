<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\PriceList;
use App\Models\Category;
use Hash;

class PriceController extends Controller
{
	public function editPricing(Request $request)
	{
		$request->validate([
			'category_id' => 'required',
			'days' => 'required',
			'amount' => 'required',
			'deposit' => 'required',
			// 'hourly_charge_amount' => 'required',
		]);

		$data = PriceList::find($request->id);
		$data->category_id = $request->category_id;
		$data->days = $request->days;
		$data->price = $request->amount;
		$data->deposit = $request->deposit;
		// $data->hourly_charge_amount = $request->hourly_charge_amount;
		$data->save();
		return redirect('prices/all')->with('success','Pricing details updated successfully');
	}

	public function editPricingPage($id)
	{
		$data = PriceList::where('id',$id)->first();
		if($data)
		{
			$categories = Category::where('is_active',1)->get();
			return view('prices.edit',compact('data','categories'));
		}
		return redirect()->back()->with('error','Pricing details not found');
	}

	public function getAllPricing(Request $request)
	{
		if($request->ajax())
		{
			$data = PriceList::join('categories','categories.id','price_lists.category_id');
			if($request->search_data!=null)
			{
			    $data = $data->where(function($query) use ($request){
			        $query->where('categories.category_name','like','%'.$request->search_data.'%')
			        ->orWhere('price_lists.price','like','%'.$request->search_data.'%')
			        ;
			    });
			}
			$data = $data->select('price_lists.*','categories.category_name');
			return DataTables::of($data)->make(true);
		}
		return view('prices.all');
	}

	public function getAddPricing()
	{
		$categories = Category::where('is_active',1)->get();
		return view('prices.add',compact('categories'));
	}
	public function addPricing(Request $request)
	{
		$request->validate([
			'category_id' => 'required',
			'days' => 'required',
			'amount' => 'required',
			'deposit' => 'required',
			// 'hourly_charge_amount' => 'required',
		]);

		$check = PriceList::where('category_id',$request->category_id)->where('days',$request->days)->first();
		if($check)
		{
			return redirect()->back()->with('error','Pricing already exists for '.$request->days.' days');
		}

		$data = new PriceList();
		$data->category_id = $request->category_id;
		$data->days = $request->days;
		$data->price = $request->amount;
		$data->deposit = $request->deposit;
		// $data->hourly_charge_amount = $request->hourly_charge_amount;
		$data->save();
		return redirect('prices/all')->with('success','Pricing added successfully');
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

		$response = PriceList::find($request->id);
		if($response)
		{	
			if($response->is_active == 1)
				$response->is_active = 0;
			else
				$response->is_active = 1;

			$response->save();
			return redirect()->back()->with('success','Pricing status updated successfully');
		}
		else
		{
			return redirect()->back()->with('error','Unable to change status');
		}  
	}
}
