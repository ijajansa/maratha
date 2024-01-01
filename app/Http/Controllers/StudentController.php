<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\User;
use App\Models\UserDocument;
use App\Services\UserServices;
use Hash;
use Illuminate\Validation\Rule;


class StudentController extends Controller
{
    protected  $StudentService;
    public function __construct()
    {
        $this->StudentService = new UserServices();
    }

    public function verifyDocumentFront($id)
    {
        $data = UserDocument::find($id);
        if($data)
        {
            $data->is_adhaar_front_verified = 2;
            $data->save();
        }
        return redirect()->back()->with('success','Aadhar front verified successfully');
    }
    public function verifyDocumentBack($id)
    {
        $data = UserDocument::find($id);
        if($data)
        {
            $data->is_adhaar_back_verified = 2;
            $data->save();
        }
        return redirect()->back()->with('success','Aadhar back verified successfully');

    }
    public function verifyDocumentLicense($id)
    {
        $data = UserDocument::find($id);
        if($data)
        {
            $data->is_license_verified = 2;
            $data->save();
        }
        return redirect()->back()->with('success','Driving license verified successfully');

    }

    public function rejectDocumentFront($id)
    {
        $data = UserDocument::find($id);
        if($data)
        {
            $data->is_adhaar_front_verified = 3;
            $data->save();
        }
        return redirect()->back()->with('success','Aadhar front rejected successfully');
    }
    public function rejectDocumentBack($id)
    {
        $data = UserDocument::find($id);
        if($data)
        {
            $data->is_adhaar_back_verified = 3;
            $data->save();
        }
        return redirect()->back()->with('success','Aadhar back rejected successfully');

    }
    public function rejectDocumentLicense($id)
    {
        $data = UserDocument::find($id);
        if($data)
        {
            $data->is_license_verified = 3;
            $data->save();
        }
        return redirect()->back()->with('success','Driving license rejected successfully');

    }
    
    public function getAllStudents(Request $request)
    {
    	if($request->ajax())
    	{
    		$data = User::where('role_id','3')->orderBy('created_at','DESC');
    		if($request->status!=null)
    		{
    		    if($request->status==1)
    		    $data = $data->where('is_document_verified',$request->status);
    		    else
    		    $data = $data->where('is_document_verified',0);
    		    
    		}
    		return DataTables::of($data)->make(true);
    	}
    	return view('customers.all');
    }

    public function getAddStudent()
    {
    	return view('students.add');
    }
    public function addStudent(Request $request)
    {
    	$request->validate([
    		'name' => 'required',
    		'email' => 'required|unique:users|email',
    		'contact_number' => 'required|unique:users|digits:10',
    		'parent_contact_number' => 'required|numeric|digits:10',
    		'address' => 'required',
    		'college_name' => 'required',
    		'payment_type' => 'required',
    		'gender' => 'required',
    	]);

    	$record = $request->all();
    	$record['role_id'] = 3;
        unset($record['_token']);
        
        $response = $this->StudentService->createUser($record);
        if($response)
        {
        	return redirect('students/edit/'.$response->id)->with('success','Student record added successfully');
        }
    	return redirect('students/all')->with('error','Unable to create student profile');
    }

    public function deleteStudent($id)
    {
    	$response = $this->StudentService->delete($id);
    	if($response)
    	{
    		return redirect()->back()->with('success','Student record deleted successfully');		
    	}
    	else
    	{
    		return redirect()->back()->with('error','Unable to delete student');		
    	}
    }
    
    public function editStudentPage($id)
    {
        $data = User::where('role_id',3)->where('id',$id)->first();
        if($data)
        {
            $user_documents = UserDocument::where('user_id',$data->id)->first();
            return view('customers.edit',compact('data','user_documents'));
        }
        return redirect()->back()->with('error','User not found');
    }
    
    public function postUpdateStudent(Request $request)
    {
        $request->validate([
    		'name' => 'required',
    		'email' => ['required',Rule::unique('users')->ignore($request->id),],
    		'contact_number' => ['required',Rule::unique('users')->ignore($request->id),'digits:10'],
    		'parent_contact_number' => 'required|numeric|digits:10',
    		'address' => 'required',
    		'college_name' => 'required',
    		'payment_type' => 'required',
    		'gender' => 'required',
    	]);
        
        $data = $request->all();
        $data['id'] = $request->id ?? 0;
        unset($data['_token']);
        $response = $this->StudentService->updateUser($data);
        if($response)
        {
            $user = User::find($response->id)->first();
            if($user)
            {
                $user->payment_type = $request->payment_type ?? null;
                $user->save();
            }
            return redirect()->back()->with('success','Student record updated successfully');
        }
        else
        {
            return redirect()->back()->with('error','Unable to update record');
        }

    }
    
    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8'
            ]);
        $data = $request->all();
        $data['id'] = $request->id ?? 0;
        $response = $this->StudentService->updatePassword($data);
        if($response)
        {
            return redirect()->back()->with('success','Password updated successfully');
        }
        else
        {
            return redirect()->back()->with('error','Unable to update student record');
        }  
        
    }
    
    public function changeStatus($id)
    {
        $response = $this->StudentService->changeStatus($id);
        if($response)
        {
            return redirect()->back()->with('success','Student status changed successfully');
        }
        else
        {
            return redirect()->back()->with('error','Unable to change student record');
        }  
    }
}
