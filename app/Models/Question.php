<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

	protected $fillable = [
		'chapter_id',
		'question_text',
		'question_image',
		'solution',
		'solution_text',
		'solution_image',
		'option1',
		'option1_image',
		'option1_type',
		'option2',
		'option2_image',
		'option2_type',
		'option3',
		'option3_image',
		'option3_type',
		'option4',
		'option4_image',
		'option4_type'
	]; 

    public function options()
    {
    	return $this->hasMany('App\Models\Answer','question_id','id');
    }
}
