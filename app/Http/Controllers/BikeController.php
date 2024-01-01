<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Services\UserServices;
use App\Services\SubjectService;
use App\Services\StandardService;
use App\Models\Bike;
use App\Models\BikeImages;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Modal;
use App\Models\Year;
use App\Models\Store;
use Auth;
use Hash;
use File;
use Illuminate\Validation\Rule;


class BikeController extends Controller
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
    		$data = Bike::leftJoin('categories','categories.id','bikes.category_id')
    		->leftJoin('brands','brands.id','bikes.brand_id')
    		->leftJoin('models','models.id','bikes.model_id')
    		->leftJoin('users','users.id','bikes.dealer_id')
    		->leftJoin('stores','stores.id','bikes.store_id');
            if(Auth::user()->role_id !=1)
            {
                $data = $data->where('stores.id',Auth::user()->store_id);
            }
            if($request->search_record!=null)
            {
                $data = $data->where(function($query) use ($request){
                    $query->where('categories.category_name','like','%'.$request->search_record.'%')
                    ->orWhere('brands.brand_name','like','%'.$request->search_record.'%')
                    ->orWhere('models.model_name','like','%'.$request->search_record.'%')
                    ->orWhere('bikes.registration_number','like','%'.$request->search_record.'%')
                    ->orWhere('stores.store_name','like','%'.$request->search_record.'%'); 
                });
            }
    		$data = $data->select('bikes.*','brands.brand_name','models.model_name','categories.category_name','users.name as user_name','stores.store_name')
    		
    		->orderBy('id','DESC');
    		return DataTables::of($data)->make(true);
    	}
    	
    	return view('bikes.all');
    }

    public function getAddSubject()
    {
        $categories = Category::where('is_active',1)->get();
        $brands = Brand::where('is_active',1)->get();
        $models = Modal::where('is_active',1)->get();
        $years = Year::where('is_active',1)->get();
        $stores = Store::where('is_active',1)->get();
    	return view('bikes.add',compact('categories','brands','models','years','stores'));
    }

    public function addSubject(Request $request)
    {
    	$request->validate([
            'category_id' => 'required',
            'brand_id' => 'required',
            'model_id' => 'required',
            'registration_number' => 'required|unique:bikes',
            'registration_year_id' => 'required',
            'chassis_number' => 'nullable|unique:bikes',
            'engine_number' => 'nullable|unique:bikes',
            'store_id' => 'required',
            'puc_image' => 'required_if:is_puc,==,on',
            'insurance_image' => 'required_if:is_insurance,==,on',
            'document_image' => 'required_if:is_documents,==,on'
        ]);
        

        $data = $request->all();
        $data['is_puc'] = $request->is_puc == "on" ? 1 : 0;
        $data['is_insurance'] = $request->is_insurance == "on" ? 1 : 0;
        $data['is_documents'] = $request->is_document == "on" ? 1 : 0;
        $data['registration_number'] = strtoupper($request->registration_number);
        $data['dealer_id'] = Auth::user()->id ?? 0;
        $data['latitude'] = Auth::user()->latitude ?? 0;
        $data['puc_image'] = $request->puc_image->store('puc_images');
        $data['insurance_image'] = $request->puc_image->store('insurance_images');
        $data['document_image'] = $request->puc_image->store('document_images');
        unset($data['_token']);
        $res = Bike::create($data);
        if($res)
        {
            if($request->image!=null)
            {
            foreach ($request->image as $key => $value) {
                $path = $value->store('bike_images');
                $new = new BikeImages();
                $new->images = $path;
                $new->bike_id = $res->id ?? 0;
                $new->save();
            }
            }
            return redirect('bikes/all')->with('success','Bike details uploaded successfully !');
        }
        else
        {
            return redirect()->back()->with('error','Unable to upload details !');
        }
    }

    public function changeStatus($id)
    {
        $data = Bike::find($id);
        if($data && $data->is_active==1)
        {
            $data->is_active =0;
            $data->save();
            return redirect()->back()->with('success','Bike details inactivated successfully');
        }
        else if($data && $data->is_active==0)
        {
            $data->is_active = 1;
            $data->save();
            return redirect()->back()->with('success','Bike details activated successfully');
        }
        else
        {
            return redirect()->back()->with('error','Unable to change status');
        }  
    }

    public function deleteSubject($id)
    {
    	$response = BikeImages::find($id);
        if($response)
        {
            if(\File::exists(storage_path('app/'.$response->images)))
            {
                \File::delete(storage_path('app/'.$response->images));
            }
            $response->delete();
            return redirect()->back()->with('success','Vehicle image deleted successfully');
        }
        else
        {
            return redirect()->back()->with('error','Something went wrong');
        }  
    }

    public function editSubjectPage($id)
    {
    	$data = Bike::find($id);
        $categories = Category::where('is_active',1)->get();
        $brands = Brand::where('is_active',1)->get();
        $models = Modal::where('is_active',1)->get();
        $years = Year::where('is_active',1)->get();
        $images = BikeImages::where('bike_id',$data->id)->get();
        $stores = Store::where('is_active',1)->get();
    	if($data)
    	{
    		return view('bikes.edit',compact('data','categories','brands','models','years','images','stores'));
    	}
    	return redirect()->back('error','Bike details not found');
    }

    public function postUpdateSubject(Request $request)
    {
    	$request->validate([
            'category_id' => 'required',
            'brand_id' => 'required',
            'model_id' => 'required',
            'registration_number' => 'required|unique:bikes,registration_number,'.$request->id.',id',
            'registration_year_id' => 'required',
            'chassis_number' => 'nullable|unique:bikes,chassis_number,'.$request->id.',id',
            'engine_number' => 'nullable|unique:bikes,engine_number,'.$request->id.',id',
            'image[]' => 'nullable|mimes:jpg,jpeg,png'
        ]);

        $check_bike = Bike::find($request->id);
        if($check_bike)
        {
            if($request->is_puc == 'on' && $check_bike->puc_image==null)
            {
                if($request->puc_image==null)
                {
                    return redirect()->back()->withInput($request->all())->withErrors(['puc_image' => 'the puc image field is required.']);
                }
            }

            if($request->is_insurance == 'on' && $check_bike->insurance_image==null)
            {
                if($request->insurance_image==null)
                {
                    return redirect()->back()->withInput($request->all())->withErrors(['insurance_image' => 'the insurance image field is required.']);
                }
                }
            if($request->is_document == 'on' && $check_bike->document_image==null)
            {
                if($request->document_image==null)
                {
                    return redirect()->back()->withInput($request->all())->withErrors(['insurance_image' => 'the document image field is required.']);
                }
            }
        }

    	$record = $request->all();
    	$record['id'] = $request->id ?? 0;
        $record['is_puc'] = $request->is_puc == "on" ? 1 : 0;
        $record['is_insurance'] = $request->is_insurance == "on" ? 1 : 0;
        $record['is_documents'] = $request->is_document == "on" ? 1 : 0;
        $record['registration_number'] = strtoupper($request->registration_number);
        unset($record['_token']);
        unset($record['is_document']);
        unset($record['image']);
        if($request->puc_image!=null)
        $record['puc_image'] = $request->file('puc_image')->store('puc_images');
        if($request->insurance_image!=null)
        $record['insurance_image'] = $request->file('insurance_image')->store('insurance_images');
        if($request->document_image!=null)
        $record['document_image'] = $request->file('document_image')->store('document_images');

        $bike = Bike::find($request->id);
        $response = Bike::where('id',$request->id)->update($record);
        if($response)
        {
            if($request->image!=null)
            {
                foreach ($request->image as $key => $value) {
                    $path = $value->store('bike_images');
                    $new = new BikeImages();
                    $new->images = $path ?? null;
                    $new->bike_id = $bike->id ?? 0;
                    $new->save();
                }
            }
        	return redirect('bikes/all')->with('success','Bike details updated successfully');
        }
        	return redirect('bikes/all')->with('error','Something went wrong');

    }

}
