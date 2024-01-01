<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Question;
use App\Models\Chapter;
use App\Services\QuestionService;
use Hash;
use Illuminate\Validation\Rule;


class QuestionController extends Controller
{
    protected  $QuestionService;
    public function __construct()
    {
        $this->QuestionService = new QuestionService();
    }
    
    public function getAllQuestions(Request $request)
    {
    	if($request->ajax())
    	{
    		$data = $this->QuestionService->getMCQList();
    		return DataTables::of($data)->make(true);
    	}
    	return view('questions.all');
    }

    public function getAddQuestion()
    {
    	$chapters = Chapter::where('chapters.is_active',1)
    	->join('subjects','subjects.id','chapters.subject_id')
        ->join('standards','standards.id','subjects.standard_id')
        ->select('chapters.*','subjects.name AS subject_name','standards.name AS standard_name')
        ->get();
    	return view('questions.add',compact('chapters'));
    }
    public function addQuestion(Request $request)
    {
    	$request->validate([
    		'chapter_id' => 'required',
    		'question_text' => 'required',
    		'question_image' => 'required',
    		'solution' => 'required',
    		'solution_text' => 'required',
    		'solution_image' => 'required',
    		'option1' => 'required',
    		'option1_image' => 'required',
    		'option1_type' => 'required',
    		'option2' => 'required',
    		'option2_image' => 'required',
    		'option2_type' => 'required',
    		'option3' => 'required',
    		'option3_image' => 'required',
    		'option3_type' => 'required',
    		'option4' => 'required',
    		'option4_image' => 'required',
    		'option4_type' => 'required'
    	]);

    	$record = $request->all();
        unset($record['_token']);
        
        $response = $this->QuestionService->createQuestion($record);
        if($response)
        {
        	return redirect('mcq-questions/all')->with('success','Question added successfully');
        }
    	return redirect('mcq-questions/all')->with('error','Unable to add question');
    }

    public function deleteQuestion($id)
    {
    	$response = Question::find($id);
    	if($response)
    	{
    		$response->delete();
    		return redirect()->back()->with('success','Question deleted successfully');		
    	}
    	else
    	{
    		return redirect()->back()->with('error','Unable to delete');		
    	}
    }
    
    public function editStudentPage($id)
    {
        $response = $this->StudentService->fetch($id);
        if($response)
        {
            return view('students.edit',compact('response'));
        }
        else
        {
            return redirect()->back()->with('error','Unable to get student record');
        }
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
        $response = $this->QuestionService->changeStatus($id);
        if($response)
        {
            return redirect()->back()->with('success','Status changed successfully');
        }
        else
        {
            return redirect()->back()->with('error','Unable to change status');
        }  
    }
}
