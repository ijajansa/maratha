<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Services\UserServices;
use App\Services\SubjectService;
use App\Services\StandardService;
use App\Services\ChapterService;
use App\Services\ChapterFormatService;
use Hash;
use Illuminate\Validation\Rule;


class ModelController extends Controller
{
    protected  $SubjectService;
    protected  $StandardService;
    protected  $ChapterService;
    protected  $ChapterFormatService;
    public function __construct()
    {
        $this->SubjectService = new SubjectService();
        $this->StandardService = new StandardService();
        $this->ChapterService = new ChapterService();
        $this->ChapterFormatService = new ChapterFormatService();
    }
    
    public function getAllChapters(Request $request)
    {
    	if($request->ajax())
    	{
    		$record = $request->subject ?? null;
    		$data = $this->ChapterFormatService->fetch($record);
    		return DataTables::of($data)->make(true);
    	}
    	return view('models.all');
    }

    public function getAddChapter()
    {
        $brands = $this->ChapterService->fetch();
    	return view('models.add',compact('brands'));
    }

    public function addChapter(Request $request)
    {
    	$request->validate([
            'brand_id' => 'required',
    		'model_name' => 'required',
    	]);

    	$record = $request->all();
        unset($record['_token']);
        $response = $this->ChapterFormatService->create($record);
        if($response)
        {
        	return redirect('models/all')->with('success','Model added successfully');
        }
        	return redirect('models/all')->with('error','Something went wrong');
    }

    public function changeStatus($id)
    {
        $response = $this->ChapterFormatService->changeStatus($id);
        if($response)
        {
            return redirect()->back()->with('success','Model status changed successfully');
        }
        else
        {
            return redirect()->back()->with('error','Unable to change status');
        }  
    }

    public function deleteChapter($id)
    {
    	$response = $this->ChapterFormatService->delete($id);
        if($response)
        {
            return redirect()->back()->with('success','Model deleted successfully');
        }
        else
        {
            return redirect()->back()->with('error','Unable to delete model');
        }  
    }

    public function editChapterPage($id)
    {
        $brands = $this->ChapterService->fetch();
    	$data = $this->ChapterFormatService->fetchSingle($id);
    	if($data)
    	{
    		return view('models.edit',compact('data','brands'));
    	}
    	return redirect()->back('error','Model details not found');
    }

    public function postUpdateChapter(Request $request)
    {
    	$request->validate([
    		'brand_id' => 'required',
            'model_name' => 'required'
    	]);

    	$record = $request->all();
    	$record['id'] = $request->id ?? 0;
        unset($record['_token']);
        $response = $this->ChapterFormatService->update($record);
        if($response)
        {
        	return redirect('models/all')->with('success','Model details updated successfully');
        }
        	return redirect('models/all')->with('error','Something went wrong');

    }

}
