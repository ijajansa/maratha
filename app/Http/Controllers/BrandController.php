<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Brand;
use App\Models\Modal;
use App\Services\UserServices;
use App\Services\SubjectService;
use App\Services\StandardService;
use App\Services\ChapterService;
use Hash;
use Illuminate\Validation\Rule;


class BrandController extends Controller
{
    protected  $SubjectService;
    protected  $StandardService;
    protected  $ChapterService;
    public function __construct()
    {
        $this->SubjectService = new SubjectService();
        $this->StandardService = new StandardService();
        $this->ChapterService = new ChapterService();
    }
    
    public function getBrands(Request $request)
    {
        $data = Brand::where('category_id',$request->category_id)->where('is_active',1)->get();
        $html = '<option value="">Select Brand</option>';
        foreach ($data as $key => $value) {
            $html.='<option value="'.$value->id.'">'.$value->brand_name.'</option>';
        }
        return $html;
    }
    public function getModels(Request $request)
    {
        $data = Modal::where('brand_id',$request->brand_id)->where('is_active',1)->get();
        $html = '<option value="">Select Model</option>';
        foreach ($data as $key => $value) {
            $html.='<option value="'.$value->id.'">'.$value->model_name.'</option>';
        }
        return $html;
    }
    
    public function getAllChapters(Request $request)
    {
    	if($request->ajax())
    	{
    		$record = $request->subject ?? null;
    		$data = $this->ChapterService->fetch($record);
    		return DataTables::of($data)->
    		addColumn('brand_image',function($row){
    			if($row->brand_image!=null)
    			{
    				return "<a href='".url('storage/app')."/".$row->brand_image."'><img src='".url('storage/app')."/".$row->brand_image."' width='45px' height='45px'>";
    			}
    			else
    			{
    				return "<img src='".asset('assets/images/default.svg')."' width='45px' height='45px'>";
    			}
    		})
    		->rawColumns(['brand_image'])->make(true);
    	}
    	return view('brands.all');
    }

    public function getAddChapter()
    {
    	$data = $this->SubjectService->get();
    	return view('brands.add',compact('data'));
    }

    public function addChapter(Request $request)
    {
    	$request->validate([
    		'brand_name' => 'required',
    		'image' => 'required|mimes:jpg,png,jpeg,svg',
    // 		'category_id' => 'required'
    	]);

    	$record = $request->all();
        unset($record['_token']);
        $response = $this->ChapterService->create($record);
        if($response)
        {
        	return redirect('brands/all')->with('success','Brand added successfully');
        }
        	return redirect('brands/all')->with('error','Something went wrong');
    }

    public function changeStatus($id)
    {
        $response = $this->ChapterService->changeStatus($id);
        if($response)
        {
            return redirect()->back()->with('success','Brand status changed successfully');
        }
        else
        {
            return redirect()->back()->with('error','Unable to change brand record');
        }  
    }

    public function deleteChapter($id)
    {
    	$response = $this->ChapterService->delete($id);
        if($response)
        {
            return redirect()->back()->with('success','Brand deleted successfully');
        }
        else
        {
            return redirect()->back()->with('error','Unable to delete brand');
        }  
    }

    public function editChapterPage($id)
    {
    	$data = $this->SubjectService->get();    	
    	$record = $this->ChapterService->fetchSingle($id);
    	if($record)
    	{
    		return view('brands.edit',compact('data','record'));
    	}
    	return redirect()->back('error','Brand detail not found');
    }

    public function postUpdateChapter(Request $request)
    {
    	$request->validate([
    		'brand_name' => 'required',
            'image' => 'nullable|mimes:jpg,png,jpeg,svg',
            // 'category_id' => 'required'
    	]);

    	$record = $request->all();
    	$record['id'] = $request->id ?? 0;
        unset($record['_token']);
        $response = $this->ChapterService->update($record);
        if($response)
        {
        	return redirect('brands/all')->with('success','Brand details updated successfully');
        }
        	return redirect('brands/all')->with('error','Something went wrong');

    }

}
