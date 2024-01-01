<?php
namespace App\Services;
use App\Models\Standard;
use Storage;

class StandardService
{
	protected $StandardModel;
    public function __construct()
    {
    	$this->StandardModel = new Standard();
    }

    public function fetch()
    {
    	return $this->StandardModel->where('is_active',1)->get();
    }

}
