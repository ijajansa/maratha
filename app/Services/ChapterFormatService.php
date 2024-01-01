<?php
namespace App\Services;
use App\Models\ChapterFormat;
use App\Models\Chapter;
use App\Models\Modal;
use Storage;

class ChapterFormatService
{
	protected $ChapterModel;
	protected $ChapterFormatModel;
    public function __construct()
    {
    	$this->ChapterModel = new Chapter();
    	$this->ChapterFormatModel = new Modal();
    }

    public function fetchChapterType()
    {
    	return $this->ChapterFormatModel->where('is_active',1)->select('id','name')->get();
    }
    public function fetchChapters(array $data=[])
    {
    	return $this->ChapterModel->where(['is_active' => 1,'format_id' => $data['format_id'],'subject_id' => $data['subject_id']])->get();
    }

    public function fetch($data)
    {
        return $this->ChapterFormatModel->join('brands','brands.id','models.brand_id')
        ->select('models.*','brands.brand_name')
        ->get();
    }
    
    public function formats()
    {
        return $this->ChapterFormatModel->where('is_active',1)->get();
    }
    
    public function create($record)
    {
        return $this->ChapterFormatModel->create($record);
    }
    public function changeStatus($id)
    {
        $record = $this->ChapterFormatModel->where('id',$id)->first();
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
        return $record = $this->ChapterFormatModel->where('id',$id)->delete();
    }
    
    public function fetchSingle($id)
    {
        return $this->ChapterFormatModel->where(['id'=>$id])->first();
    }
    
    public function update($data)
    {
        $id = $data['id'];
        unset($data['id']);
        return $this->ChapterFormatModel->where('id',$id)->update($data);
    }
}
