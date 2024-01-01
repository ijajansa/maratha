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
								<h4 class="nk-block-title">All Booking Requests</h4>
							</div>
							<div class="nk-block-head-content" style="text-align: end;width: 50%">
                            
							</div><!-- .nk-block-head-content -->
						</div>
						<div class="card card-preview">
							<div class="card-inner">
                                <div class="row" style="margin-bottom:20px;">
                                        <div class="col-lg-3">
                                            <label class="form-label" for="phone-no-1">Select Booking Date</label>
                                            <input type="date" @if(request()->query('date')) value="{{request()->query('date')}}" @endif id="date" onchange="applyFilter()" class="form-control">
                                        </div>
                                        
                                        <div class="col-lg-3">
                                            <label class="form-label" for="phone-no-1">Select Address Type</label>
                                            <select class="form-control form-select" onchange="applyFilter()" data-search="off" data-placeholder="Select Address Type" id="address_type" data-ui="md">
                                                <option value="">Select Address Type</option>
                                                <option value="Self Pickup">Self Pickup</option>
                                                <option value="Delivery at location">Delivery at location</option>
                                            </select>
                                        </div>
                                        
                                        <div class="col-lg-3">
                                            <label class="form-label" for="phone-no-1">Search</label>
                                            <input type="text" placeholder="Type in search" class="form-control" id="search_field" onkeyup="applyFilter()">
                                            </div>
                                    </div>
                                    
								<table class="nowrap table" id="myTable">
									<thead>
										<th>Id</th>
										<th>Booking Id</th>
										<th>Vehicle Number</th>
										<th>Customer Name</th>
										<th>Contact Number</th>
										<th>Address Type</th>
										<th>Created At</th>
										<th>Start Date</th>
										<th>End Date</th>
										<th>Action</th>                              
									</thead>
									<tbody>

									</tbody>
								</table>
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

	$(document).ready(function(){
		loadData();
	});

	function loadData()
	{
        date = $("#date").val();
        address_type = $("#address_type").val();
        search_record = $("#search_field").val();
        @if(request()->query('status')) 
        status = "{{request()->query('status')}}";
        @endif
        
		NioApp.DataTable('#myTable', {
			"processing": true,
			"serverSide": true,
			"searching":false,
			"bLengthChange":false,
			"responsive": true,
			ajax:"{{url('bookings/all')}}?date="+date+"&address_type="+address_type+"&search_record="+search_record+"&status="+status,
			"order":[
			[0,"asc"]
			],
			lengthMenu: [
			[10, 100, 500, -1],
			[10, 100, 500, "All"]
			],
			"columns":[
			{
				"mData":"id"
			},
			{
				"mData":"booking_id"
			},
			{
				"mData":"bike_details.registration_number"
			},
			{
				"mData":"customer_name"
			},
			{
				"mData":"customer_number"
			},
			{
				"mData":"address_type"
			},
			{
			  "mData":"created_date"  
			},
			{
				"mData":"formated_start_date"
			},
			{
				"mData":"formated_end_date"
			},
			{
				"targets":-1,
				"mData": "id",
				"bSortable": false,
				"ilter":false,
				"mRender": function(data, type, row){
					return '<a class="btn btn-primary btn-sm" href={{url("bookings")}}/edit/'+row.id+'><span><em class="icon ni ni-edit"></em></span>&nbsp;&nbsp;Details</a>';
				},

			},
			]          

		});
	}
</script>

<script type="text/javascript">

	function deleteRecord(id)
	{
		Swal.fire({
			title: 'Are you sure?',
			text: "You won't be able to revert this !",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Yes, delete it!'
		}).then(function (result) {
			if (result.value) {
				window.location.href="{{url('bookings/delete')}}/"+id;
			}
		});
	}
	
</script>

@endsection