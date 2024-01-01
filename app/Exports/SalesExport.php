<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\BookingRequest;


class SalesExport implements FromCollection, WithHeadings
{
    public $from_date;
    public $to_date;

    public function __construct($data)
    {
        $this->from_date = $data['from_date'];
        $this->to_date = $data['to_date'];
    }
    public function collection()
    {
        $data = BookingRequest::where('booking_requests.booking_status',6)
    		->leftJoin('users','users.id','booking_requests.customer_id')
    		->leftJoin('bikes','bikes.id','booking_requests.vehicle_id')
    		->leftJoin('invoices','invoices.booking_id','booking_requests.id');
    

    		if($this->from_date!=null && $this->to_date!=null)
    		{
    			$data = $data->whereDate('booking_requests.created_at','>=',$this->from_date)->whereDate('booking_requests.created_at','<=',$this->to_date);
    		}
    		if($this->from_date!=null && $this->to_date==null)
    		{
    			$data = $data->whereDate('booking_requests.created_at','>=',$this->from_date);
    		}
    		if($this->from_date==null && $this->to_date!=null)
    		{
    			$data = $data->whereDate('booking_requests.created_at',$this->to_date);
    		}
   
    		$data = $data->orderBy('booking_requests.created_at','ASC')
    		->select(\DB::raw("DATE_FORMAT(booking_requests.created_at, '%d-%b-%Y') as formatted_date"),'booking_requests.booking_id','invoices.invoice_id','users.name','users.contact_number',\DB::raw('booking_requests.charges + booking_requests.advance_amount'),'booking_requests.advance_amount','booking_requests.charges')->get();
            return $data;
    		
    }

    public function headings(): array
    {
        return [
            'Booking Date',
            'Booking ID',
            'Invoice Number',
            'Customer Name',
            'Customer Number',
            'Gross Amount',
            'Refundable Amount',
            'Net Amount'
        ];
    }
}
