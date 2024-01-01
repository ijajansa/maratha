@extends('layouts.app')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="nk-content" style="margin-top: 60px;">
	<div class="container-fluid">
		<div class="nk-content-inner">
			<div class="nk-content-body">
				<div class="components-preview  mx-auto">
					<div class="nk-block nk-block-lg">
						<div class="nk-block-head">
							@if(session('success'))
							<div class="alert alert-success alert-icon"><em class="icon ni ni-check-circle"></em> <strong>{{session('success')}}</strong></div>
							@endif
							@if(session('error'))
							<div class="alert alert-danger alert-icon"><em class="icon ni ni-cross-circle"></em> <strong>{{session('error')}}</strong></div>
							@endif
							<div class="nk-block-head-content">
								<h4 class="title nk-block-title">View Customer Details</h4>

							</div>
						</div>
						<div class="card card-bordered">
							<div class="card-inner">

								<form method="post" enctype="multipart/form-data" action="{{url('users/edit')}}/{{$data->id}}">
									<input readonly type="hidden" name="_token" value="{{csrf_token()}}">
									<div class="row g-4">

										<div class="col-lg-6">
											<div class="form-group">
												<label for="exampleFormControlInput1" class="form-label text-primary">Full Name <span class="required">*</span></label>
												<input readonly type="text" class="form-control @error('name') is-invalid @enderror" id="exampleFormControlInput1" value="{{old('name',$data->name)}}" placeholder="Enter Full Name" name="name">
												@error('name')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
												@enderror
											</div>
										</div>
										<div class="col-xl-6 col-sm-6">
											<label for="exampleFormControlInput3" class="form-label text-primary">Email Address<span class="required">*</span></label>
											<input readonly type="email" class="form-control @error('email') is-invalid @enderror" id="exampleFormControlInput3" value="{{old('email',$data->email)}}" placeholder="Enter Email Address" name="email">
											@error('email')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror
										</div>
										<div class="col-xl-6 col-sm-6">
											<label for="exampleFormControlInput6" class="form-label text-primary">Contact Number <span class="required">*</span></label>
											<input readonly type="number" class="form-control @error('contact_number') is-invalid @enderror" id="exampleFormControlInput6" value="{{old('contact_number',$data->contact_number)}}" placeholder="Enter Contact Number" name="contact_number">
											@error('contact_number')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror
										</div>
										<div class="col-xl-6 col-sm-6">
											<label for="search_input" class="form-label text-primary">Address <span class="required">*</span></label>
											<input readonly type="text" class="form-control @error('address') is-invalid @enderror" id="search_input" value="{{old('address',$data->address)}}" autocomplete="off" placeholder="Enter Address" name="address">

											@error('address')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror
										</div>
										<div class="col-xl-6 col-sm-6">
											<label for="exampleFormControlInput10" class="form-label text-primary">Profile Image <span class="required">*</span></label>
											<div class="mt-1">
												@if($data->profile == null)
												<img src="{{asset('assets/images/default.svg')}}" width="90px" height="90px" id="output">
												@else
												<a href="{{url('storage/app')}}/{{$data->profile}}" target="_blank">
													<img src="{{url('storage/app')}}/{{$data->profile}}" width="90px" height="90px" id="output">
												</a>

												@endif
											</div>
										</div>
									</div>

								</div>
							</form>
						</div>
					</div>

				</div><!-- .nk-block -->

			</div><!-- .components-preview -->
			@if($user_documents)

			<div class="components-preview  mx-auto" style="margin-top: 30px;">                    
				<div class="nk-block nk-block-lg">
					<div class="nk-block-head" style="display: flex;">
						<div class="nk-block-head-content" style="width: 50%">
							<h4 class="title nk-block-title">View Uploaded Documents</h4>
						</div>

					</div>
					<div class="card card-preview">
						<div class="card-inner">

							<table class="nowrap table" id="myTable">
								<thead>
									<th>Image</th>
									<th>Document</th>
									<th>Action</th>                              
								</thead>
								<tbody>
									@if($user_documents->adhaar_front_image!=null)
									<tr>
										<td>
											<a href="{{url('storage/app')}}/{{$user_documents->adhaar_front_image}}" target="_blank">
											<img src="{{url('storage/app')}}/{{$user_documents->adhaar_front_image}}" width="100px" height="100px"></a>
										</td>
										<td>Aadhar Card Front</td>

										<td>
											@if($user_documents->is_adhaar_front_verified == 1)
											<div class="tb-odr-btns d-none d-md-inline"><a href='{{url("customers")}}/verify-adhaar-front/{{$user_documents->id}}' class="btn btn-sm btn-outline-warning">Verify Document</a></div>&nbsp;&nbsp;<div class="tb-odr-btns d-none d-md-inline"><a href='{{url("customers")}}/reject-adhaar-front/{{$user_documents->id}}' class="btn btn-sm btn-danger">Reject</a></div>
											@elseif($user_documents->is_adhaar_front_verified == 2)
											<div class="tb-odr-btns d-none d-md-inline">
												<a href="javascript:void(0)" class="btn btn-sm btn-success">Verified</a>
											</div>
											@elseif($user_documents->is_adhaar_front_verified == 3)
											<div class="tb-odr-btns d-none d-md-inline">
												<a href="javascript:void(0)" class="btn btn-sm btn-danger">Rejected</a>
											</div>
											@else
											<div class="tb-odr-btns d-none d-md-inline">
												<a href="javascript:void(0)" class="btn btn-sm btn-primary">Not Uploaded Yet</a>
											</div>
											@endif
										</td>
									</tr>
									@endif

									@if($user_documents->adhaar_back_image!=null)
									<tr>

										<td>

											<a href="{{url('storage/app')}}/{{$user_documents->adhaar_back_image}}" target="_blank">
											<img src="{{url('storage/app')}}/{{$user_documents->adhaar_back_image}}" width="100px" height="100px">
										</a>
										</td>
										<td>Aadhar Card Back</td>

										<td>
											@if($user_documents->is_adhaar_back_verified == 1)
											<div class="tb-odr-btns d-none d-md-inline"><a href='{{url("customers")}}/verify-adhaar-back/{{$user_documents->id}}' class="btn btn-sm btn-outline-warning">Verify Document</a></div>&nbsp;&nbsp;<div class="tb-odr-btns d-none d-md-inline"><a href='{{url("customers")}}/reject-adhaar-back/{{$user_documents->id}}' class="btn btn-sm btn-danger">Reject</a></div>
											@elseif($user_documents->is_adhaar_back_verified == 2)
											<div class="tb-odr-btns d-none d-md-inline">
												<a href="javascript:void(0)" class="btn btn-sm btn-success">Verified</a>
											</div>
											@elseif($user_documents->is_adhaar_back_verified == 3)
											<div class="tb-odr-btns d-none d-md-inline">
												<a href="javascript:void(0)" class="btn btn-sm btn-danger">Rejected</a>
											</div>
											@else
											<div class="tb-odr-btns d-none d-md-inline">
												<a href="javascript:void(0)" class="btn btn-sm btn-primary">Not Uploaded Yet</a>
											</div>
											@endif
										</td>
									</tr>
									@endif

									@if($user_documents->driving_license_image!=null)
									<tr>
										<td>

											<a href="{{url('storage/app')}}/{{$user_documents->driving_license_image}}" target="_blank">
											<img src="{{url('storage/app')}}/{{$user_documents->driving_license_image}}" width="100px" height="100px">
										</a>
										</td>
										<td>Driving License</td>

										<td>
											@if($user_documents->is_license_verified == 1)
											<div class="tb-odr-btns d-none d-md-inline"><a href='{{url("customers")}}/verify-driving-license/{{$user_documents->id}}' class="btn btn-sm btn-outline-warning">Verify Document</a></div>&nbsp;&nbsp;<div class="tb-odr-btns d-none d-md-inline"><a href='{{url("customers")}}/reject-driving-license/{{$user_documents->id}}' class="btn btn-sm btn-danger">Reject</a></div>
											@elseif($user_documents->is_license_verified == 2)
											<div class="tb-odr-btns d-none d-md-inline">
												<a href="javascript:void(0)" class="btn btn-sm btn-success">Verified</a>
											</div>
											@elseif($user_documents->is_license_verified == 3)
											<div class="tb-odr-btns d-none d-md-inline">
												<a href="javascript:void(0)" class="btn btn-sm btn-danger">Rejected</a>
											</div>
											@else
											<div class="tb-odr-btns d-none d-md-inline">
												<a href="javascript:void(0)" class="btn btn-sm btn-primary">Not Uploaded Yet</a>
											</div>
											@endif
										</td>
									</tr>
									@endif
								</tbody>
							</table>
						</div>
					</div><!-- .card-preview -->
				</div> <!-- nk-block -->
			</div><!-- .components-preview -->
			@endif

		</div>
	</div>
</div>
</div>


@endsection