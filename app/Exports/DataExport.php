<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\BookingRequest;


class DataExport implements FromCollection, WithHeadings
{
    public $from_date;
    public $to_date;
    public $category_id;
    public $store_id;

    public function __construct($data)
    {
        $this->from_date = $data['from_date'];
        $this->to_date = $data['to_date'];
        $this->category_id = $data['category_id'];
        $this->store_id = $data['store_id'];
    }
    public function collection()
    {
        $array = [];
        $data = BookingRequest::leftJoin('users','users.id','booking_requests.customer_id')
    		->leftJoin('bikes','bikes.id','booking_requests.vehicle_id')
    		->leftJoin('stores','stores.id','bikes.store_id')
    		->leftJoin('booking_statuses','booking_statuses.id','booking_requests.booking_status');

    		if($this->from_date!=null && $this->to_date!=null)
    		{
    			$data = $data->whereDate('booking_requests.created_at','>=',$this->from_date)->whereDate('booking_requests.created_at','<=',$this->to_date);
    		}
    		if($this->from_date!=null && $this->to_date==null)
    		{
    			$data = $data->whereDate('booking_requests.created_at',$this->from_date);
    		}
    		if($this->from_date==null && $this->to_date!=null)
    		{
    			$data = $data->whereDate('booking_requests.created_at',$this->to_date);
    		}
    		
    		if($this->category_id!="null")
    		{
    			$data = $data->where('bikes.category_id',$this->category_id);
    		}
    		
    		$data = $data->orderBy('booking_requests.created_at','ASC')->select('booking_requests.booking_id',\DB::raw("DATE_FORMAT(booking_requests.created_at, '%d-%b-%Y') as formatted_date"),'bikes.registration_number','stores.store_name','users.name','booking_statuses.name as status_name')->get();
            return $data;
    		
    }

    public function headings(): array
    {
        return [
            'Booking ID',
            'Booking Date',
            'Vehicle Number',
            'Store',
            'Customer Name',
            'Status'
        ];
    }
}
