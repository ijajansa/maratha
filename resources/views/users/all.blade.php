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
								<h4 class="nk-block-title">All System Users</h4>
							</div>
							<div class="nk-block-head-content" style="text-align: end;width: 50%">
								<div class="toggle-wrap nk-block-tools-toggle">
									<a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
									<div class="toggle-expand-content" data-content="pageMenu">
										<a href="{{url('users/add')}}" class="btn btn-primary nk-block-tools-opt"><em class="icon ni ni-plus"></em><span>Add New User</span></a>
									</div>
								</div><!-- .toggle-wrap -->
							</div><!-- .nk-block-head-content -->
						</div>
						<div class="card card-preview">
							<div class="card-inner">

								<table class="nowrap table" id="myTable">
									<thead>
										<th>Id</th>
										<th>Name</th>
										<th>Email ID</th>
										<th>Contact Number</th>
										<th>Status</th>
										<th>Verify</th>
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

		NioApp.DataTable('#myTable', {
			"processing": true,
			"serverSide": true,
			"searching":true,
			"bLengthChange":true,
			"responsive": true,
			ajax:"{{url('users/all')}}",
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
						return '<div class="tb-odr-btns d-none d-md-inline"><a href={{url("users")}}/status/'+row.id+' class="btn btn-sm btn-success">Active</a></div>';
					}
					else
					{
						return '<div class="tb-odr-btns d-none d-md-inline"><a href={{url("users")}}/status/'+row.id+' class="btn btn-sm btn-danger">Inactive</a></div>';
					}
				},

			},
			{
				"targets":-1,
				"mData": "id",
				"bSortable": false,
				"ilter":false,
				"mRender": function(data, type, row){
					if(row.is_document_verified==1)
					{
						return '<div class="tb-odr-btns d-none d-md-inline"><a href={{url("users")}}/verify/'+row.id+' class="btn btn-sm btn-outline-warning">Verify Document</a></div>&nbsp;&nbsp;<div class="tb-odr-btns d-none d-md-inline"><a href={{url("users")}}/reject/'+row.id+' class="btn btn-sm btn-danger">Reject</a></div>';
					}
					else if(row.is_document_verified==2)
					{
						return '<div class="tb-odr-btns d-none d-md-inline"><a href=javascript:void(0) class="btn btn-sm btn-success">Verified</a></div>';
					}
					else if(row.is_document_verified==3)
					{
						return '<div class="tb-odr-btns d-none d-md-inline"><a href= href=javascript:void(0) class="btn btn-sm btn-outline-danger">Rejected</a></div>';
					}
					else
					{
						return 'not uploaded';
					}
				},

			},
			{
				"targets":-1,
				"mData": "id",
				"bSortable": false,
				"ilter":false,
				"mRender": function(data, type, row){
					return '<a class="btn btn-primary btn-sm" href={{url("users")}}/edit/'+row.id+'><span><em class="icon ni ni-edit"></em></span>&nbsp;&nbsp;Details</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
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