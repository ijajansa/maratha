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
								<h4 class="nk-block-title">All Registered Customers</h4>
							</div>
							
						</div>
						<div class="card card-preview">
							<div class="card-inner">

								<table class="nowrap table" id="myTable">
									<thead>
										<th>Id</th>
										<th>Profile</th>
										<th>Name</th>
										<th>Email ID</th>
										<th>Contact Number</th>
										<th>Status</th>
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
        @if(request()->query('status')) 
        status = "{{request()->query('status')}}";
        @endif
        
		NioApp.DataTable('#myTable', {
			"processing": true,
			"serverSide": true,
			"searching":true,
			"bLengthChange":true,
			"responsive": true,
			ajax:"{{url('customers/all')}}?status="+status,
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
				"targets":-1,
				"mData": "id",
				"bSortable": false,
				"ilter":false,
				"mRender": function(data, type, row){
					if(row.is_active==1)
					{
						return '<div class="tb-odr-btns d-none d-md-inline"><a href={{url("customers")}}/status/'+row.id+' class="btn btn-sm btn-success">Active</a></div>';
					}
					else
					{
						return '<div class="tb-odr-btns d-none d-md-inline"><a href={{url("customers")}}/status/'+row.id+' class="btn btn-sm btn-danger">Inactive</a></div>';
					}
				},

			},
			{
				"targets":-1,
				"mData": "id",
				"bSortable": false,
				"ilter":false,
				"mRender": function(data, type, row){
					return '<a class="btn btn-primary btn-sm" href={{url("customers")}}/edit/'+row.id+'><span><em class="icon ni ni-edit"></em></span>&nbsp;&nbsp;Details</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
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
				window.location.href="{{url('users/delete')}}/"+id;
			}
		});
	}
	
</script>

@endsection