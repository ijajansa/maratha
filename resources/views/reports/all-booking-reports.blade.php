@extends('layouts.app')
@section('content')
<!-- content @s -->
<div class="nk-content" style="margin-top: 50px;">
	<div class="container-fluid">
		<div class="nk-content-inner">
			<div class="nk-content-body">
				<div class="components-preview  mx-auto">                    
					<div class="nk-block nk-block-lg">
						@if(session('error'))
						<div class="alert alert-danger alert-icon"><em class="icon ni ni-cross-circle"></em> <strong>{{session('error')}}</strong></div>
						@endif
						@if(session('success'))
						<div class="alert alert-success alert-icon"><em class="icon ni ni-check-circle"></em> <strong>{{session('success')}}</strong></div>
						@endif
						<div class="nk-block-head" style="display: flex;">

							<div class="nk-block-head-content" style="width: 50%">
								<h4 class="nk-block-title">All Booking Report</h4>
							</div>
							<div class="nk-block-head-content" style="width: 50%">
								<p align="right">
								    <button class="btn btn-primary" onclick="downloadBookingReport()"><i class="icon ni ni-download"></i>&nbsp; Export Excel</button>
								</p>
							</div>
							
						</div>
						<div class="card card-preview">
							<div class="card-inner">
								<div class="row">
									<div class="col-lg-3 col-sm-3">
										<label class="form-label">From Date</label>
										<input type="date" class="form-control" id="from_date" onchange="applyFilter(this.value)">
									</div>
									<div class="col-lg-3 col-sm-3">
										<label class="form-label">Till Date</label>
										<input type="date" class="form-control" id="to_date" onchange="applyFilter(this.value)">
									</div>
									<!--<div class="col-lg-3 col-sm-3">-->
									<!--	<label class="form-label">Select Address Type</label>-->
									<!--	<select class="form-control form-select" id="type" onchange="applyFilter(this.value)">-->
									<!--		<option value="null">Select Type</option>-->
									<!--		<option value="Self Pickup">Self Pickup</option>-->
									<!--		<option value="Delivery at Location">Delivery at Location</option>-->
									<!--	</select>-->
									<!--</div>-->
									<div class="col-lg-3 col-sm-3">
										<label class="form-label">Select Category</label>
										<select class="form-control form-select" id="category_id" data-search-="on" onchange="applyFilter(this.value)">
											<option value="null">Select Category</option>
											@foreach($categories as $category)
											<option value="{{$category->id}}">{{$category->category_name}}</option>
											@endforeach
										</select>
									</div>
									<!--<div class="col-lg-3 col-sm-3 mt-2">-->
									<!--	<label class="form-label">Select Brand</label>-->
									<!--	<select class="form-control form-select" id="brand_id"  data-search-="on" onchange="applyFilter(this.value)">-->
									<!--		<option value="null">Select Brand</option>-->
									<!--		@foreach($brands as $brand)-->
									<!--		<option value="{{$brand->id}}">{{$brand->brand_name}}</option>-->
									<!--		@endforeach-->
									<!--	</select>-->
									<!--</div>-->
									<div class="col-lg-3 col-sm-3">
										<label class="form-label">Select Store</label>
										<select class="form-control form-select" id="store_id"  data-search-="on" onchange="applyFilter(this.value)">
											<option value="null">Select Store</option>
											@foreach($stores as $store)
											<option value="{{$store->id}}">{{$store->store_name}}</option>
											@endforeach
										</select>
									</div>
									<!--<div class="col-lg-3 col-sm-3 mt-2">-->
									<!--	<label class="form-label">Select Booking Status</label>-->
									<!--	<select class="form-control form-select" id="status"  data-search-="on" onchange="applyFilter(this.value)">-->
									<!--		<option value="null">Select Status</option>-->
									<!--		@foreach($statuses as $status)-->
									<!--		<option value="{{$status->id}}">{{$status->name}}</option>-->
									<!--		@endforeach-->
									<!--	</select>-->
									<!--</div>-->
									<!-- <div class="col-lg-3 col-sm-3 mt-2">
										<button class="btn btn-primary btn-md"><i class="ni ni-download" style="font-size: 18px;"></i>&nbsp;&nbsp;Export Excel</button>
									</div> -->
									<div class="col-lg-12 mt-2">
										<table class="nowrap table" id="myTable">
									<thead>
										<th>Id</th>
										<th>Booking ID</th>
										<th>Booking Date</th>
                                        <th>Vehicle Number</th>
										<th>Store</th>
										<th>Customer Name</th>
										<th>Status</th>
									</thead>
									<tbody>

									</tbody>
								</table>
									</div>
								</div>
								
							</div>
						</div><!-- .card-preview -->
					</div> <!-- nk-block -->
				</div><!-- .components-preview -->
			</div>
		</div>
	</div>

</div>
<!-- content @e -->



<script type="text/javascript">

	function applyFilter()
	{
		$("#myTable").DataTable().clear().destroy();
		loadData();
	}
	
	function downloadBookingReport()
	{
	    from_date = $("#from_date").val();
		to_date = $("#to_date").val();
		category_id = $("#category_id").val();
		store_id = $("#store_id").val();
		
		window.location.href="{{url('download-booking-report')}}?from_date="+from_date+"&to_date="+to_date+"&category_id="+category_id+"&store_id="+store_id;
	}

	$(document).ready(function(){
		loadData();
	});

	function loadData()
	{

		from_date = $("#from_date").val();
		to_date = $("#to_date").val();
		category_id = $("#category_id").val();
		store_id = $("#store_id").val();

		NioApp.DataTable('#myTable', {
			"processing": true,
			"serverSide": true,
			"searching":false,
			"bLengthChange":false,
			"responsive": true,
			ajax:"{{url('booking-reports/all')}}?from_date="+from_date+"&to_date="+to_date+"&category_id="+category_id+"&store_id="+store_id,
			"order":[
			[0,"asc"]
			],
			lengthMenu: [
			[10, 100, 500, -1],
			[10, 100, 500, "All"]
			],
			"columns":[
			{
                "mData":"id",
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
				"mData":"booking_id"
			},
			{
				"mData":"booking_date"
			},
			{
				"mData":"registration_number"
			},
			{
				"mData":"store_name"
			},
			{
				"mData":"name"
			},
			
			{
				"mData":"status_name"
			},
		
			]          

		});
	}
</script>

@endsection