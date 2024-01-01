<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Store;
use App\Models\UserDocument;
use Hash;

class StoreController extends Controller
{
    public function editStore(Request $request)
    {
        $request->validate([
            'store_name' => 'required',
    		'store_contact_number' => 'required|unique:stores,store_contact_number,'.$request->id.'|digits:10',
    		'store_gstin_number' => 'nullable',
    		'address' => 'required',
    		'store_url' => 'required',
            'image' => 'nullable|mimes:jpg,png,jpeg,svg',
        ]);

        $data = Store::find($request->id);
        if($data)
        {
            if($request->image!=null)
            {
                $path = $request->image->store('store_images');
            }    
            $data->store_name = $request->store_name;
            $data->store_contact_number = $request->store_contact_number;
            $data->store_gstin_number = $request->store_gstin_number;
            $data->store_address = $request->address;
            $data->store_latitude = $request->lat;
            $data->store_longitude = $request->lng;
            $data->store_url = $request->store_url;
            if($request->image!=null)
            {
                $data->store_image = $path ?? null;
            }
            $data->save();
            return redirect('stores/all')->with('success','Store details updated successfully');
        }
    }

    public function editStorePage($id)
    {
        $data = Store::where('id',$id)->first();
        if($data)
        {
            return view('stores.edit',compact('data'));
        }
        return redirect()->back()->with('error','Store not found');
    }

    public function getAllStore(Request $request)
    {
    	if($request->ajax())
    	{
    		$data = Store::orderBy('id','DESC');
    		return DataTables::of($data)->make(true);
    	}
    	return view('stores.all');
    }

    public function getAddStore()
    {
    	return view('stores.add');
    }
    public function addStore(Request $request)
    {
    	$request->validate([
    		'store_name' => 'required',
    		'store_url' => 'required',
    		'store_contact_number' => 'required|unique:stores|digits:10',
    		'store_gstin_number' => 'nullable',
    		'address' => 'required',
            'image' => 'required|mimes:jpg,png,jpeg,svg',
        ]);

        if(isset($request->image))
        {
            $path = $request->image->store('store_images');
        }    

        $data = new Store();
        $data->store_name = $request->store_name;
        $data->store_contact_number = $request->store_contact_number;
        $data->store_gstin_number = $request->store_gstin_number;
        $data->store_address = $request->address;
        $data->store_latitude = $request->lat;
        $data->store_longitude = $request->lng;
        $data->store_image = $path ?? null;
        $data->store_url = $request->store_url;
        $data->save();
        return redirect('stores/all')->with('success','Store added successfully');
    }

    public function deleteStore($id)
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
    $response = Store::find($id);
    if($response)
    {
        if($response->is_active == 1)
            $response->is_active =0;
        else
            $response->is_active =1;
        $response->save();

        return redirect()->back()->with('success','Store status changed successfully');
    }
    else
    {
        return redirect()->back()->with('error','Unable to change store record');
    }  
}


}
