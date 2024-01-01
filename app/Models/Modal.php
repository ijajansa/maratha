<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modal extends Model
{
	protected $table = 'models';
    protected $fillable = ['brand_id','model_name'];
}
