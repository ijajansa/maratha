<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Services\UserServices;
use App\Services\SubjectService;
use App\Services\StandardService;
use App\Models\Category;

use Hash;
use Illuminate\Validation\Rule;


class CategoryController extends Controller
{
    protected  $SubjectService;
    protected  $StandardService;
    public function __construct()
    {
        $this->SubjectService = new SubjectService();
        $this->StandardService = new StandardService();
    }
    
    public function getAllSubjects(Request $request)
    {
    	if($request->ajax())
    	{
    		$record = $request->subject ?? null;
    		$data = $this->SubjectService->fetchRecord($record);
    		return DataTables::of($data)->
    		addColumn('image',function($row){
    			if($row->image!=null)
    			{
    				return "<img src='".url("storage/app")."/".$row->image."' width='45px' height='45px'>";
    			}
    			else
    			{
    				return "<img src='".asset('assets/images/default.svg')."' width='45px' height:45px>";
    			}
    		})
    		->rawColumns(['image'])->make(true);
    	}
    	return view('categories.all');
    }

    public function getAddSubject()
    {
    	return view('categories.add');
    }

    public function addSubject(Request $request)
    {
    	$request->validate([
    		'category_name' => 'required',
    		'image' => 'required|mimes:jpg,png,svg,jpeg',
    	]);

    	$record = $request->all();
        unset($record['_token']);
        $response = $this->SubjectService->create($record);
        if($response)
        {
        	return redirect('categories/all')->with('success','Category added successfully');
        }
        	return redirect('categories/all')->with('error','Something went wrong');
    }

    public function changeStatus($id)
    {
        $response = $this->SubjectService->changeStatus($id);
        if($response)
        {
            return redirect()->back()->with('success','Category status changed successfully');
        }
        else
        {
            return redirect()->back()->with('error','Unable to change category record');
        }  
    }

    public function deleteSubject($id)
    {
    	$response = $this->SubjectService->delete($id);
        if($response)
        {
            return redirect()->back()->with('success','Categories deleted successfully');
        }
        else
        {
            return redirect()->back()->with('error','Unable to delete category');
        }  
    }

    public function editSubjectPage($id)
    {
    	$data = $this->SubjectService->fetchSingle($id);
    	if($data)
    	{
    		return view('categories.edit',compact('data'));
    	}
    	return redirect()->back('error','Category details not found');
    }

    public function postUpdateSubject(Request $request)
    {
    	$request->validate([
    		'category_name' => 'required',
    		'image' => 'nullable|mimes:jpg,png,svg,jpeg'
    	]);

    	$record = $request->all();
    	$record['id'] = $request->id ?? 0;
        unset($record['_token']);
        $response = $this->SubjectService->update($record);
        if($response)
        {
        	return redirect('categories/all')->with('success','Category details updated successfully');
        }
        	return redirect('categories/all')->with('error','Something went wrong');

    }

}
