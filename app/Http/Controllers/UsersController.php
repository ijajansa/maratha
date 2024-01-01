<?php

namespace App\Http\Controllers;

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
            'email' => 'required|unique:users,email,'.$request->id.'|email',
            'contact_number' => 'required|unique:users,contact_number,'.$request->id.'|digits:10',
            'store_id' => 'required',
            'password' => 'nullable|min:8',
            'image' => 'nullable|mimes:jpg,png,jpeg,pdf',
        ]);

        $data = User::find($request->id);
        if($data)
        {
            if($request->image!=null)
            {
                $path = $request->image->store('document_images');
            }    

            $record = $request->all();
            $record['password'] = Hash::make($record['password']);

            $data->name = $record['name'];
            $data->email = $record['email'];
            $data->contact_number = $record['contact_number'];
            $data->store_id = $record['store_id'];
            if($request->password!=null)
            {
                $data->password = $record['password'];
            }
            if($request->image!=null)
            {
                $data->is_document_verified = 1;
                $data->document_image = $path ?? null;   
            }
            $data->save();
            return redirect('users/all')->with('success','System user details updated successfully');
        }
    }

    public function verifyDocument($id)
    {
        $data = User::find($id);
        if($data)
        {
            $data->is_document_verified = 2;
            $data->save();
        }
        return redirect()->back()->with('success','Document verified successfully');
    }
    public function rejectDocument($id)
    {
        $data = User::find($id);
        if($data)
        {
            $data->is_document_verified = 3;
            $data->save();
        }
        return redirect()->back()->with('success','Document rejected successfully');
    }
    public function editUserPage($id)
    {
        $stores = Store::where('is_active',1)->get();
        $data = User::where('role_id',2)->where('id',$id)->first();
        if($data)
        {
            return view('users.edit',compact('data','stores'));
        }
        return redirect()->back()->with('error','User not found');
    }

    public function getAllUsers(Request $request)
    {
    	if($request->ajax())
    	{
    		$data = User::where('role_id','2');
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
    	$data = User::find($id);
    	if($data)
    	{
            $data->is_active = 0;
            $data->save();
            return redirect()->back()->with('success','User deleted successfully');		
        }
        else
        {
          return redirect()->back()->with('error','Unable to delete user');		
      }
  }

  public function changeStatus($id)
  {
    $response = User::find($id);
    if($response)
    {
        if($response->is_active == 1)
            $response->is_active =0;
        else
            $response->is_active =1;
        $response->save();

        return redirect()->back()->with('success','System user status changed successfully');
    }
    else
    {
        return redirect()->back()->with('error','Unable to change user record');
    }  
}


}
