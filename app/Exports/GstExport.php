<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\BookingRequest;


class GstExport implements FromCollection, WithHeadings
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
    		->join('invoices','invoices.booking_id','booking_requests.id');

    		if($this->from_date!=null && $this->to_date!=null)
    		{
    			$data = $data->whereDate('invoices.created_at','>=',$this->from_date)->whereDate('invoices.created_at','<=',$this->to_date);
    		}
    		if($this->from_date!=null && $this->to_date==null)
    		{
    			$data = $data->whereDate('invoices.created_at','>=',$this->from_date);
    		}
    		if($this->from_date==null && $this->to_date!=null)
    		{
    			$data = $data->whereDate('invoices.created_at',$this->to_date);
    		}

    		$data = $data->orderBy('invoices.invoice_id','ASC')
    		->select('invoices.invoice_id',\DB::raw("DATE_FORMAT(invoices.created_at, '%d-%b-%Y') as formatted_date"),'users.name','booking_requests.final_amount','booking_requests.advance_amount',\DB::raw('booking_requests.charges + booking_requests.delivery_charges + booking_requests.additional_charges'),booking_requests.additional_charges,\DB::raw('booking_requests.gst/2 as cgst'),\DB::raw('booking_requests.gst/2 as sgst'),'booking_requests.gst')->get();
            return $data;
    		
    }

    public function headings(): array
    {
        return [
            'Invoice Number',
            'Invoice Date',
            'Customer Name',
            'Total Invoice Amount',
            'Deposit Amount',
            'Taxable Amount',
            'Late Fee',
            'CGST 2.5%',
            'SGST 2.5%',
            'Total GST 5%'
        ];
    }
}
