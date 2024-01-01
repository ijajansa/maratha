<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
	<base href="../../../">
	<meta charset="utf-8">
	<meta name="author" content="Softnio">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<!-- Fav Icon  -->
	<link rel="shortcut icon" href="{{asset('images/favicon.png')}}">
	<!-- Page Title  -->
	<title>VeGO | Panel</title>
	<!-- StyleSheets  -->
	<link rel="stylesheet" href="{{asset('assets/css/dashlite.css?ver=2.7.0')}}">
	<link id="skin-default" rel="stylesheet" href="{{asset('assets/css/theme.css?ver=2.7.0')}}">
	<style type="text/css">
		/*        .card-bordered {*/
			/*    border: 1px solid #dbdfea;*/
			/*}*/

			@media (min-width: 768px)
			{
				.card-inner-lg {
					padding: 25px 2.5rem;
				}    
			}

		
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

		.hidePrint{
			display:none !important; 
		}
	}
	.wide-xs {
        max-width: 100% !important;
    }
		</style>
	</head>

	<body class="nk-body bg-white npc-general pg-auth">
		<div class="nk-app-root">
			<!-- main @s -->
			<div class="nk-main ">
				<!-- wrap @s -->
				<div class="nk-wrap nk-wrap-nosidebar">
					<!-- content @s -->
					<div class="nk-content ">
						<div class="nk-block nk-block-middle nk-auth-body  wide-xs" style="background: #fff;border-radius: 0px;">
		
<div class="card card-bordered" style="border:none;">
	<div class="card-inner card-inner-lg">
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
							<p><b>{{$data->additional_charges}}</b></p>
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
<!--  <div class="nk-footer nk-auth-footer-full">
<div class="container wide-lg">
<div class="row g-3">                                
<div class="col-lg-6">
<div class="nk-block-content text-center text-lg-left">
<p class="text-soft"> &copy; 2023 <a href="https://bpointer.com/" target="_blank"></p>
</div>
</div>
</div>
</div>
</div> -->
</div>
<!-- wrap @e -->
</div>
<!-- content @e -->
</div>
<!-- main @e -->
</div>
<!-- app-root @e -->
<!-- JavaScript -->
<script src="{{asset('assets/js/bundle.js?ver=2.7.0')}}"></script>
<script src="{{asset('assets/js/scripts.js?ver=2.7.0')}}"></script>

</html>