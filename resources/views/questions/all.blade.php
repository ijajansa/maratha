@extends('layouts.app')
@section('title', 'All MCQ Questions')
@section('content')
<style>
    .badge{
        cursor:pointer;
    }
</style>
<div class="container-fluid">
	<div class="row">
		
		<div class="col-xl-12">
			@include('layouts.flash')
			<div class="card" id="accordion-four">
				<div class="card-header flex-wrap d-flex justify-content-between px-3">
					<div class="col-lg-6" style="width: 50%">
						<h4 class="card-title">Questions List</h4>
					</div>
					<div class="col-lg-6" style="width: 50%;">
						<p align="right" style="margin: 0;padding: 0">
							<input type="text" class="form-control form-control-sm" placeholder="Search ..." id="search" onkeyup="ajaxRefresh(this.value)" style="width: 200px">
						</p>
					</div>
				</div>
				<!-- /tab-content -->	
				<div class="tab-content" id="myTabContent-3">
					<div class="tab-pane fade show active" id="withoutBorder" role="tabpanel" aria-labelledby="home-tab-3">
						<div class="card-body p-0">
							<div class="table-responsive">
								
								<table id="myTable" class="display table" style="width: 100%">
									<thead>
										<tr>
											<th>Id</th>
											<th>Standard</th>
											<th>Subject</th>
											<th>Chapter Name</th>
											<th>Question</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										
									</tbody>
								</table>
							</div>
						</div>
					</div>

				</div>
				<!-- /tab-content -->	

			</div>
		</div>
	</div>
	
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		datatable();
	});

	function datatable()
	{
		search = $("#search").val();
		var table = $('#myTable').DataTable({
			"searching":false,
			"lengthChange":false,
			"processing": true,
			"serverSide": true,
			"responsive": true,
			"language": {
				paginate: {
					next: '<i class="fa-solid fa-angle-right"></i>',
					previous: '<i class="fa-solid fa-angle-left"></i>' 
				}
			},
			"ajax":"{{url('mcq-questions/all')}}?questions="+search,
			"columns":[
			{
				"mData": "id",
				render: function (data, type, row, meta) {
					return meta.row + meta.settings._iDisplayStart + 1;
				}
			},
			{
				"mData": "standard_name",
				"bSortable": false,
			},
			{
				"mData": "subject_name",
				"bSortable": false,
			},
			{
				"mData": "chapter_name",
				"bSortable": false,
			},
			{
				"mData": "question_text",
				"bSortable": false,
			},
			{
				"targets": -1,
				"mData": "id",
				"bSortable": false,
				"ilter": false,
				"mRender": function (data, type, row) {
					if (row.is_active == 0)
						return '<span class="badge light badge-danger" onclick="changeStatus('+row.id+')">Inactive</span>';
					else
						return '<span class="badge light badge-success" onclick="changeStatus('+row.id+')">Active</span>';
				},

			},
			
			{
				"targets": -1,
				"mData": "id",
				"bSortable": false,
				"ilter": false,
				"mRender": function (data, type, row) {
					return '<div class="d-flex"><a href="{{url("mcq-questions/edit")}}/'+row.id+'" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a><a href="#" onclick="deleteRecord('+row.id+')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a></div>';

				}
			}
			]
		});
	}

	function ajaxRefresh(val){
		$('#myTable').DataTable().destroy().clear();
		datatable();
	}
	
	function changeStatus(id)
	{
	    if(confirm('Are you sure want to change status ?'))
	    {
	        window.location.href="{{url('mcq-questions/status')}}/"+id;
	    }
	    
	}
	
	function deleteRecord(id)
	{
	    if(confirm('Are you sure want to delete permanently ?'))
	    {
	        window.location.href="{{url('mcq-questions/delete')}}/"+id;
	    }
	    
	}

</script>
@endsection