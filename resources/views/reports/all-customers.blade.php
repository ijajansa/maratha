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
								<h4 class="nk-block-title">Registration Report</h4>
							</div>
							
						</div>
						<div class="card card-preview">
							<div class="card-inner">
								<div class="row">
									<div class="col-lg-3">
										<label class="form-label">Search By Name/Contact Number</label>
										<input type="text" class="form-control" placeholder="Type in to Search" id="name" onkeyup="applyFilter(this.value)">
									</div>

									<div class="col-lg-3">
										<label class="form-label">Registration From</label>
										<input type="date" class="form-control" id="from_date" onchange="applyFilter(this.value)">
									</div>

									<div class="col-lg-3">
										<label class="form-label">Registration To</label>
										<input type="date" class="form-control" id="to_date" onchange="applyFilter(this.value)">
									</div>
									<div class="col-lg-3">
										<label class="form-label">Select Status</label>
										<select class="form-control form-select" id="status" onchange="applyFilter(this.value)">
											<option value="null">Select Status</option>
											<option value="1">Active</option>
											<option value="0">Inactive</option>
										</select>
									</div>
									<!-- <div class="col-lg-3 mt-3">
										<button class="btn btn-primary btn-md"><i class="ni ni-download" style="font-size: 18px;"></i>&nbsp;&nbsp;Export Excel</button>
									</div> -->
									<div class="col-lg-12 mt-2">
										<table class="nowrap table" id="myTable">
									<thead>
										<th>Id</th>
										<th>Profile</th>
										<th>Name</th>
										<th>Email ID</th>
										<th>Contact Number</th>
										<th>Registration Date</th>
										<th>Status</th>
										<th>Action</th>
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

	$(document).ready(function(){
		loadData();
	});

	function loadData()
	{

		name = $("#name").val();
		from_date = $("#from_date").val();
		to_date = $("#to_date").val();
		status = $("#status").val();

		NioApp.DataTable('#myTable', {
			"processing": true,
			"serverSide": true,
			"searching":false,
			"bLengthChange":false,
			"responsive": true,
			ajax:"{{url('registration-reports/all')}}?name="+name+"&from_date="+from_date+"&to_date="+to_date+"&status="+status,
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
				"targets":-1,
				"mData": "id",
				"bSortable": false,
				"ilter":false,
				"mRender": function(data, type, row){
					if(row.profile==null)
					{
						return '<img src={{asset("assets/images/default.svg")}} width="50px" height="50px">';
					}
					else
					{
						return '<img src={{url("storage/app")}}/'+row.profile+' width="50px" height="50px">';
					}
				},

			},
			{
				"mData":"name"
			},
			{
				"mData":"email"
			},
			{
				"mData":"contact_number"
			},
			{
				"mData":"register_date"
			},
			{
				"targets":-1,
				"mData": "id",
				"bSortable": false,
				"ilter":false,
				"mRender": function(data, type, row){
					if(row.is_active==1)
					{
						return '<div class="tb-odr-btns d-none d-md-inline"><a href=javascript:void class="btn btn-sm btn-success">Active</a></div>';
					}
					else
					{
						return '<div class="tb-odr-btns d-none d-md-inline"><a href=javascript:void class="btn btn-sm btn-danger">Inactive</a></div>';
					}
				},

			},
			{
				"targets":-1,
				"mData": "id",
				"bSortable": false,
				"ilter":false,
				"mRender": function(data, type, row){
					return '<a class=datatable-left-link href={{url("customers")}}/edit/'+row.id+'><span><em class="icon ni ni-eye"></em></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				},

			},
			
			]          

		});
	}
</script>

@endsection