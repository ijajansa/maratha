<?php
namespace App\Services;
use App\Models\Standard;
use App\Models\Category;
use Storage;

class SubjectService
{
	protected $StandardModel;
    protected $SubjectModel;
    public function __construct()
    {
    	$this->StandardModel = new Standard();
    	$this->SubjectModel=new Category();
    }
    
    public function fetchRecord($data)
    {
        return $this->SubjectModel->get();
    }

    public function fetch($id)
    {
        if($id!=0)
    	return $this->SubjectModel->where(['is_active' => 1 ,'standard_id'=>$id])->get();
    	else
    	return $this->SubjectModel->where(['is_active' => 1])->get();
    	
    }

    public function fetchSubjects($record)
    {
        $data = $this->SubjectModel->join('standards','standards.id','subjects.standard_id')->orderBy('subjects.id','ASC')->select('subjects.*','standards.name AS standard_name');
        if($record!=null)
        {
            $data = $data->where(function($query) use ($record){
                $query->where('subjects.name','like','%'.$record.'%')
                ->orWhere('standards.name','like','%'.$record.'%')
                ->orWhere('subjects.type','like','%'.$record.'%');
            });
        }
        return $data;
    }

    public function create($record)
    {
        if($record['image']!=null)
        {
            $record['image'] = $record['image']->store('category_images');
        }
        return $this->SubjectModel->create($record);
    }

    public function changeStatus($id)
    {
        $record = $this->SubjectModel->where('id',$id)->first();
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
        return $record = $this->SubjectModel->where('id',$id)->delete();
    }

    public function fetchSingle($id)
    {
        return $this->SubjectModel->where(['is_active' => 1 ,'id'=>$id])->first();
    }

    public function update($data)
    {
        $id = $data['id'];
        unset($data['id']);
        if(isset($data['image']))
        {
            $data['image'] = $data['image']->store('category_images');
        }
        return $this->SubjectModel->where('id',$id)->update($data);

    }
    
    public function get()
    {
        return $this->SubjectModel->where('is_active',1)->get();
    }
}
