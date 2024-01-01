<?php
namespace App\Services;
use App\Models\Question;
use App\Models\Bookmark;
use App\Models\Enquiry;
use Storage;

class EnquiryService
{
	protected $EnquiryModel;
    public function __construct()
    {
    	$this->EnquiryModel = new Enquiry();
    }

    public function create($data = [])
    {
        return $this->EnquiryModel->create($data);
    }
}
