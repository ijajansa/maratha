<?php

namespace App\Models;

use App\Models\SabhasadFamily;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sabhasad extends Model
{
    use HasFactory;
    protected $table= 'sabhasad_data';

    public function family()
    {
        return $this->hasMany(SabhasadFamily::class,'sabhasad_id');
    }
}
