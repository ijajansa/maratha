<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use App\Exports\DataExport;
use App\Exports\SalesExport;
use App\Exports\GstExport;

class ExcelExportController extends Controller
{
    public function export(Request $request)
    {
        $data = $request->all();
        return Excel::download(new DataExport($data), 'booking-report-'.date("y-m-d").'.xls');
    }
    
    public function salesExport(Request $request)
    {
        $data = $request->all();
        return Excel::download(new SalesExport($data), 'sales-report-'.date("y-m-d").'.xls');
    }
    public function gstExport(Request $request)
    {
        $data = $request->all();
        return Excel::download(new GstExport($data), 'gst-report-'.date("y-m-d").'.xls');
    }
}
