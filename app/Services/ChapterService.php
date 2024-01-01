<?php
namespace App\Services;
use App\Models\ChapterFormat;
use App\Models\Brand;
use App\Models\BrandCategory;
use Storage;

class ChapterService
{
    protected $BrandCategoryModel;
	protected $ChapterModel;
	protected $ChapterFormatModel;
    public function __construct()
    {
    	$this->BrandCategoryModel = new BrandCategory();
    	$this->ChapterModel = new Brand();
    	$this->ChapterFormatModel = new ChapterFormat();
    }

    public function fetchChapterType()
    {
    	return $this->ChapterFormatModel->where('is_active',1)->select('id','name')->get();
    }
    public function fetchChapters(array $data=[])
    {
        if($data['format_id']!=null || $data['format_id']!=0)
        {
        	return $this->ChapterModel->where(['is_active' => 1,'format_id' => $data['format_id'],'subject_id' => $data['subject_id']])->get();
        }
        else
        {
    	    return $this->ChapterModel->where(['is_active' => 1,'subject_id' => $data['subject_id']])->get();
        }
    }

    public function fetch()
    {
    	return $this->ChapterModel->leftJoin('categories','categories.id','brands.category_id')
        ->select('brands.*','categories.category_name')
        ->get();
    }
    
    public function formats()
    {
        return $this->ChapterFormatModel->where('is_active',1)->get();
    }
    
    public function create($record)
    {
        if($record['image']!=null)
        {
            $record['brand_image'] = $record['image']->store('brand_images');
            unset($record['image']);
        }
        
        return $this->ChapterModel->create($record);
    }
    public function changeStatus($id)
    {
        $record = $this->ChapterModel->where('id',$id)->first();
        if($record && $record->is_active == 1)
        {
            $record->is_active = 0;
            $record->save();
        }
        else
        {
            $record->is_active = 1;
            $record->save();
        }
        
        return $record;
    }
    
    public function delete($id)
    {
        return $record = $this->ChapterModel->where('id',$id)->delete();
    }
    
    public function fetchSingle($id)
    {
        return $this->ChapterModel->where(['id'=>$id])->first();
    }
    
    public function update($data)
    {
        $id = $data['id'];
        unset($data['id']);
        if(isset($data['image']))
        {
            $data['brand_image'] = $data['image']->store('brand_images');
            unset($data['image']);
        }
        return $this->ChapterModel->where('id',$id)->update($data);
    }
}
