@extends('layouts.app')
@section('content')
<style>
    table th{
        text-align:center;
        border:none !important;
        
    }
    table td{
        border:none !important;
        
    }
    table .tr td{
        border: 1px solid !important;
    }
    table {
    border: 1px solid !important;
}

@media print{
  
    .nk-sidebar,.nk-header,.hidePrint{
       display:none !important; 
    }
}
</style>
<div class="nk-content " style="margin-top: 40px;">
	<div class="container-fluid">
		<div class="nk-content-inner">
			<div class="nk-content-body">
				<div class="components-preview  mx-auto">
					<div class="nk-block nk-block-lg">
						<div class="nk-block-head mt-2 hidePrint" style="display: flex;">

							<div class="nk-block-head-content" style="width: 50%">
							</div>
							<div class="nk-block-head-content" style="text-align: end;width: 50%">
							<a href="javascript:void(0)" onclick="downloadPdf()" class="btn btn-primary nk-block-tools-opt"><em class="icon ni ni-file"></em><span>Print Invoice</span></a>
							</div><!-- .nk-block-head-content -->
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="row">
									<div class="col-lg-12">
									
										<div class="card card-bordered">
											<div class="card-inner">
												<div class="row g-4">
												
                                                <div class="col-xl-12">
												<table class="table" style="width:100%">
												    <tr>
												        <th colspan="4"><h5 style="font-weight:bold">Invoice</h5></th>
												    </tr>
												    <tr>
												        <th colspan="4"><h6>VEGO bike private limited</h6></th>
												    </tr>
												    <tr>
												        <th colspan="4">
												            <p>VE GO BIKE PRIVATE LIMITED GST Number : 27AAICV6542R1ZF</p>
												        </th>
												    </tr>
												     <tr>
												        <td>
												            <p>Bike : {{$data->brand_name??''}} - {{$data->model_name ?? ''}}</p>
												        </td>
												        <td>
												            <p>SAC Code : 99541</p>
												        </td>
												    </tr>
												    <tr>
												        <td colspan="2">
												            <p>Reg. No : {{$data->registration_number??''}}</p>
												        </td>
												       
												    </tr>
												    <tr>
												        <td colspan="2">
												            <p>Pickup Address : {{$data->address??''}}</p>
												        </td>
												       
												    </tr>
												    <tr>
												        <td>
												            <p>
												                Invoice Number : {{$data->invoice_id??''}}
												            </p>
												        </td>
												        <td>
												            <p>
												                Invoice Date : {{$data->formatted_date ?? ''}}
												            </p>
												        </td>
												    </tr>
												    <tr>
												        <td>
												            <p>
												                Customer Name : {{$data->name??''}}
												            </p>
												        </td>
												        <td>
												            <p>
												                Mobile number : {{$data->contact_number ?? ''}}
												            </p>
												        </td>
												    </tr>
												    <tr class="tr">
												        <td colspan="3">
												            <p>
												                Description
												            </p>
												        </td>
												        <td>
												            <p>
												                Amount (INR)
												            </p>
												        </td>
												    </tr>
												    <tr class="tr">
												        <td colspan="3">
												            <p>
												                Ride Fee
												            </p>
												        </td>
												        <td>
												            <p>
												                {{$data->charges ?? 0}}
												            </p>
												        </td>
												    </tr>
												    <tr class="tr">
												        <td colspan="3">
												            <p>
												                Refundable Deposit
												            </p>
												        </td>
												        <td>
												            <p>
												                {{$data->advance_amount ?? 0}}
												            </p>
												        </td>
												    </tr>
												    <tr class="tr">
												        <td colspan="3">
												            <p>Delivery Charges (for home delivery)</p>
												        </td>
												        <td>
												            <p>{{$data->delivery_charges ?? 0}}</p>
												        </td>
												    </tr>
												    <tr class="tr">
												        <td colspan="3">
												            <p><b>Late fees (If applicable with 5% gst)</b></p>
												        </td>
												        <td>
												            <p><b>{{$data->additional_charges ?? 0}}</b></p>
												        </td>
												    </tr>
												    <tr class="tr">
												        <td colspan="3">
												            <p><b>Taxable Amount</b></p>
												        </td>
												        <td>
												            <p><b>{{$data->charges  + $data->delivery_charges + $data->additional_charges}}</b></p>
												        </td>
												    </tr>
												    <tr class="tr">
												        <td colspan="3">
												            <p>CGST 2.5%</p>
												        </td>
												        <td>
												            <p>{{$data->gst/2}}</p>
												        </td>
												    </tr>
												    <tr class="tr">
												        <td colspan="3">
												            <p>SGST 2.5%</p>
												        </td>
												        <td>
												            <p>{{$data->gst/2}}</p>
												        </td>
												    </tr>
													<tr class="tr">
												        <td colspan="3">
												            <p>Refundable Amount</p>
												        </td>
												        <td>
												            <p>{{$data->advance_amount - $data->additional_charges}}</p>
												        </td>
												    </tr>
												    <tr class="tr">
												        <td colspan="3">
												            <p><b>Total Customer Ride Fair</b></p>
												        </td>
												        <td>
												            <p><b>{{$data->final_amount - $data->advance_amount + $data->additional_charges}}</b></p>
												        </td>
												    </tr>
													
												    <tr>
												        <td colspan="4"></td>
												    </tr>
												    <tr>
												        <td colspan="4"></td>
												    </tr>
												    <tr class="tr">
												        <td colspan="2">
												            <p>Payment Details</p>
												        </td>
												    </tr>
												    <tr class="tr">
												        <td>
												            <p>Paid By</p>
												        </td>
												        <td>
												            <p>
															@if($data->payment_type ==1)
															Cash
															@else
															Online / UPI
															@endif
															</p>
												        </td>
												       
												    </tr>
												    <tr class="tr">
												        <td>
												            <p>Transaction Date</p>
												        </td>
												        <td>
												            <p>{{$data->created_at->format('d-M-Y')}}</p>
												        </td>
												        
												    </tr>
												    <tr class="tr">
												        <td>
												            <p>Amount</p>
												        </td>
												        <td>
												            <p>{{$data->final_amount - $data->advance_amount + $data->additional_charges}}</p>
												        </td>
												        
												    </tr>
												</table>
												</div>
                                                
											</div>
									</div>
								</div>
							</div>

						</div>
					</div>
					
				</div>
			</div><!-- .nk-block -->
		</div><!-- .components-preview -->
	</div>
</div>
</div>
</div>
<script>
    function downloadPdf()
    {
        window.print();
    }
</script>

@endsection