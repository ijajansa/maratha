<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\LocationMaster;
use App\Models\UserDocument;
use Hash;

class LocationController extends Controller
{
	public function editLocation(Request $request)
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
		return redirect('locations/all')->with('success','Self pickup location updated successfully');
	}

	public function editLocationPage($id)
	{
		$data = LocationMaster::where('id',$id)->first();
		if($data)
		{
			return view('locations.edit',compact('data'));
		}
		return redirect()->back()->with('error','Location details not found');
	}

	public function getAllLocation(Request $request)
	{
		if($request->ajax())
		{
			$data = LocationMaster::orderBy('id','DESC');
			return DataTables::of($data)->make(true);
		}
		return view('locations.all');
	}

	public function getAddLocation()
	{
		return view('locations.add');
	}
	public function addLocation(Request $request)
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
		return redirect('locations/all')->with('success','Self pickup location added successfully');
	}

	public function deleteLocation($id)
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

	public function changeStatus($id)
	{
		$response = LocationMaster::find($id);
		if($response)
		{
			if($response->is_active == 1)
				$response->is_active =0;
			else
				$response->is_active =1;
			$response->save();

			return redirect()->back()->with('success','location status changed successfully');
		}
		else
		{
			return redirect()->back()->with('error','Unable to change status');
		}  
	}
}
