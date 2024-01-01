<?php
namespace App\Services;
use App\Models\Question;
use App\Models\Offer;
use Storage;

class OfferService
{
	protected $OfferModel;
    public function __construct()
    {
    	$this->OfferModel = new Offer();
    }

    public function getOffers($user)
    {
        return $this->OfferModel->where('is_active',1)->get();
    }

    public function fetch()
    {
    	return $this->OfferModel->get();
    }
    public function create($data)
    {
        $record = $this->OfferModel;
        $record->offer_name = $data['offer_name'] ?? null;
        $record->offer_code = $data['offer_code'] ?? null;
        $record->eligibility = $data['eligibility'] ?? null;
        $record->discount_type = $data['discount_type'] ?? null;
        $record->discount_value = $data['discount_value'] ?? null;
        $record->applies_to = $data['applies_to'] ?? null;
        $record->minimum_amount = $data['minimum_amount'] ?? null;
        $record->start_date = $data['start_date'] ?? null;
        $record->end_date = $data['end_date'] ?? null;
        if(isset($data['customer_ids']) && $data['customer_ids'] !=null)
        {
            $record->customer_ids = json_encode($data['customer_ids'],true);
        }
        $record->limit1 = $data['limit1'] ?? null;
        $record->limit2 = $data['limit2'] ?? null;
        $record->usage_limit = $data['usage_limit'] ?? null;

        $record->save();
        return $record;
    }

    public function fetchSingle($id)
    {
        return $this->OfferModel->find($id);
    }

    public function update($data)
    {
        $record = $this->OfferModel->find($data['id']);
        $record->offer_name = $data['offer_name'] ?? null;
        $record->offer_code = $data['offer_code'] ?? null;
        $record->eligibility = $data['eligibility'] ?? null;
        $record->discount_type = $data['discount_type'] ?? null;
        $record->discount_value = $data['discount_value'] ?? null;
        $record->applies_to = $data['applies_to'] ?? null;
        $record->minimum_amount = $data['minimum_amount'] ?? null;
        $record->start_date = $data['start_date'] ?? null;
        $record->end_date = $data['end_date'] ?? null;
        if($data['eligibility'] == 'everyone')
        {
            $record->customer_ids = null;
        }
        else
        {
            $record->customer_ids = $data['customer_ids'] !=null ? json_encode($data['customer_ids'],true) : null;            
        }

        $record->limit1 = $data['limit1'] ?? null;
        $record->limit2 = $data['limit2'] ?? null;
        $record->usage_limit = $data['usage_limit'] ?? null;
        $record->save();
        return $record;
    }

    public function delete($id)
    {
        return $this->OfferModel->where('id',$id)->delete();
    }

    public function changeStatus($id)
    {
        $record = $this->OfferModel->find($id);
        if($record && $record->is_active ==1)
        {
            $record->is_active = 0;
        }
        else
        {
            $record->is_active = 1;
        }
        $record->save();
        return $record;
    }
}
