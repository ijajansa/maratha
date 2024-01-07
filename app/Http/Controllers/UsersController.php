<?php

namespace App\Http\Controllers;

use App\Models\Sabhasad;
use Illuminate\Http\Request;
use DataTables;
use App\Models\User;
use App\Models\Store;
use App\Models\UserDocument;
use Hash;

class UsersController extends Controller
{
    public function editUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'age' => 'required|numeric',
            'mobile_number' => 'required|unique:sabhasad_data,mobile_number,'.$request->id.'|digits:10',
            'aadhaar_card_number' => 'required|unique:sabhasad_data,aadhaar_card_number,'.$request->id.'|digits:12',
            'education' => 'required',
            'profession' => 'required',
            'current_address' => 'nullable',
            'permanent_address' => 'nullable',
            'farm' => 'required',
            'issue' => 'required',
            'exception' => 'required',
            'image' => 'nullable|mimes:jpg,png,jpeg',
        ]);

        $data = Sabhasad::find($request->id);
        if($data)
        {

            $record = $request->all();
            $data->name = $record['name'];
            $data->age = $record['age'];
            $data->mobile_number = $record['mobile_number'];
            $data->aadhaar_card_number = $record['aadhaar_card_number'];
            $data->education = $record['education'];
            $data->profession = $record['profession'];
            $data->farm = $record['farm'];
            $data->issue = $record['issue'];
            $data->exception = $record['exception'];
            $data->current_address = $record['current_address'];
            $data->permanent_address = $record['permanent_address'];
            
            if($request->image!=null)
            {
                $path = $request->image->store('profiles');
                $data->profile_image = $path ?? null;   
            }    
            $data->save();
            return redirect('users/all')->with('success','Sabhasad details updated successfully');
        }
    }

    public function editUserPage($id)
    {
        $data = Sabhasad::where('id',$id)->first();
        if($data)
        {
            return view('users.edit',compact('data'));
        }
        return redirect()->back()->with('error','Sabhasad not found');
    }

    public function getAllUsers(Request $request)
    {
    	if($request->ajax())
    	{
    		$data = Sabhasad::with('family')->orderBy('id','ASC');
    		return DataTables::of($data)->make(true);
    	}
    	return view('users.all');
    }

    public function getAddUser()
    {
        $stores = Store::where('is_active',1)->get();
    	return view('users.add',compact('stores'));
    }
    public function addUser(Request $request)
    {
    	$request->validate([
    		'name' => 'required',
    		'email' => 'required|unique:users|email',
    		'contact_number' => 'required|unique:users|digits:10',
            'password' => 'required|min:8',
            'store_id' => 'required',
            'image' => 'required|mimes:jpg,png,jpeg,pdf',
        ]);

        if(isset($request->image))
        {
            $path = $request->image->store('document_images');
        }    

        $record = $request->all();
        $record['role_id'] = 2;
        $record['password'] = Hash::make($record['password']);

        $data = new User();
        $data->name = $record['name'];
        $data->role_id = $record['role_id'];
        $data->email = $record['email'];
        $data->contact_number = $record['contact_number'];
        $data->password = $record['password'];
        $data->store_id = $record['store_id'];
        $data->is_document_verified = 1;
        $data->document_image = $path ?? null;
        $data->save();
        return redirect('users/all')->with('success','System user added successfully');
    }

    public function deleteUser($id)
    {
    	$data = Sabhasad::find($id);
    	if($data)
    	{
            $data->delete();
            return redirect()->back()->with('success','Sabhasad deleted successfully');		
        }
        else
        {
          return redirect()->back()->with('error','Unable to delete sabhasad');		
      }
  }

}
