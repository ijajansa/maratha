<?php
namespace App\Services;
use App\Models\Question;
use App\Models\Bookmark;
use Storage;

class BookmarkService
{
	protected $BookmarkModel;
    public function __construct()
    {
    	$this->BookmarkModel = new Bookmark();
    }

    public function bookmark($data = [])
    {
        $record = $this->BookmarkModel->where('user_id',$data['user_id'])->where('question_id',$data['question_id'])->first();
        if($record)
        {
            $record->delete();
            return response()->json([
                'status'=>true,
                'message'=>'Bookmark removed successfully'
            ]); 

        }
        else
        {
            $this->BookmarkModel->create($data);
            return response()->json([
                'status'=>true,
                'message'=>'Bookmark added successfully'
            ]); 
        }

        return response()->json([
                'status'=>false,
                'message'=>'Something went wrong'
            ]); 
    }
    
    public function list($data = [])
    {
        return $this->BookmarkModel->join('questions','questions.id','bookmarks.question_id')->where('bookmarks.user_id',$data['user_id'])->select('questions.*')->get();
    }

}
