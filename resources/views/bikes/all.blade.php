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
								<h4 class="nk-block-title">All Bikes</h4>
							</div>
							<div class="nk-block-head-content" style="text-align: end;width: 50%">
								<div class="toggle-wrap nk-block-tools-toggle">
									<a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
									<div class="toggle-expand-content" data-content="pageMenu">
										<a href="{{url('bikes/add')}}" class="btn btn-primary nk-block-tools-opt"><em class="icon ni ni-plus"></em><span>Add Bike</span></a>
									</div>
								</div><!-- .toggle-wrap -->
							</div><!-- .nk-block-head-content -->
						</div>
						<div class="card card-preview">
							<div class="card-inner">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <input type="text" placeholder="Type into search" id="search" class="form-control" onkeyup="applyFilter()">
                                    </div>
                                </div>
								<table class="nowrap table" id="myTable">
									<thead>
										<th>ID</th>
										<th>Category</th>
										<th>Brand Name</th>
										<th>Model Name</th>
										<th>Vehicle Registration Number</th>
										<th>Added By</th>
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
        search_result = $("#search").val();
		NioApp.DataTable('#myTable', {
			"processing": true,
			"serverSide": true,
			"searching":false,
			"bLengthChange":false,
			"responsive": true,
			ajax:"{{url('bikes/all')}}?search_record="+search_result,
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
				"mData":"category_name"
			},
			{
				"mData":"brand_name"
			},
			{
				"mData":"model_name"
			},
			{
				"mData":"registration_number"
			},
			
			{
				"targets":-1,
				"mData": "id",
				"bSortable": false,
				"ilter":false,
				"mRender": function(data, type, row){
					if(row.user_name==null)
					{
						return '-';
					}
					else
					{
						return row.user_name;
					}
				},

			},
			{
				"targets":-1,
				"mData": "id",
				"bSortable": false,
				"ilter":false,
				"mRender": function(data, type, row){
					if(row.is_active==1)
					{
						return '<div class="tb-odr-btns d-none d-md-inline"><a href={{url("bikes")}}/status/'+row.id+' class="btn btn-sm btn-success">Active</a></div>';
					}
					else
					{
						return '<div class="tb-odr-btns d-none d-md-inline"><a href={{url("bikes")}}/status/'+row.id+' class="btn btn-sm btn-danger">Inactive</a></div>';
					}
				},

			},
			{
				"targets":-1,
				"mData": "id",
				"bSortable": false,
				"ilter":false,
				"mRender": function(data, type, row){
					return '<a class="btn btn-primary btn-sm" href={{url("bikes")}}/edit/'+row.id+'><span><em class="icon ni ni-edit"></em></span>&nbsp;&nbsp;Details</a>';
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
				window.location.href="{{url('bikes/delete')}}/"+id;
			}
		});
	}
	
</script>

@endsection