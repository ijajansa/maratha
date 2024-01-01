@extends('layouts.app')
@section('content')
<style type="text/css">
	.card-bordered{
		width: 100%;
	}
		@media(max-width: 600px)
	{
		.card-bordered{
			width: 100%;
		}	
	}
</style>

<div class="nk-content " style="margin-top: 60px;">
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
								<h4 class=" nk-block-title">Send Push Notification</h4>

							</div>
						</div>
						<div class="card card-bordered">
							<div class="card-inner">

								<form method="post" onsubmit="hideButton()" enctype="multipart/form-data" action="{{url('notifications/add')}}">
									<input type="hidden" name="_token" value="{{csrf_token()}}">
									<div class="row g-4">
										<div class="col-xl-6 col-sm-6">
											<label for="imageUpload" class="form-label text-primary">Image</label>
											<input type="file" class="form-control @error('image') is-invalid @enderror" id="imageUpload" value="{{old('image')}}" name="image" onchange="showImagePreview(event)" accept=".png, .jpg, .jpeg">
											@error('image')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror

										</div>
										<div class="col-lg-6">
											<div class="form-group">
												<label for="imageUpload" class="form-label text-primary">Title <span class="required">*</span></label>
												<div class="form-control-wrap">
													<input type="text" id="demo-text-input" name="title" class="form-control form-control-md @error('title') is-invalid @enderror" placeholder="Enter Notification Title" value="{{old('title')}}" />
													@error('title')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
													@enderror
												</div>
											</div>
										</div>

										<div class="col-lg-12">
											<div class="form-group">
												<label for="imageUpload" class="form-label text-primary">Description <span class="required">*</span></label>
												<div class="form-control-wrap">
													
													<textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="5" placeholder="Enter Notification Description">{{old('description')}}</textarea>
													@error('description')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
													@enderror
												</div>
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-group">
												<label for="E1234" class="form-label text-primary">Select Customer <span class="required">*</span></label>
												<div class="form-control-wrap">
													<select class="form-control form-select  @error('users') is-invalid @enderror" multiple data-search="on" name="users[]">
														<option value="all" selected>All</option>
														@foreach($users as $user)
														<option value="{{$user->id}}">{{$user->name ?? ''}}</option>
														@endforeach
													</select>
													@error('users')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
													@enderror
												</div>
											</div>
										</div>

										<div class="col-xl-12 col-sm-12">
												<img src="{{asset('assets/images/default.svg')}}" id="output" style="width:90px;height:90px">
										</div>

										<div class="col-12">
											<div class="form-group">
												<button type="submit" id="btn" class="btn btn-lg btn-primary">Send Notification</button>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>

					</div><!-- .nk-block -->

				</div><!-- .components-preview -->
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	function showImagePreview(event) {
		var element = document.getElementById("imageUpload");
		var output2 = document.getElementById('output');
		output2.src = URL.createObjectURL(event.target.files[0]);
		output2.onload = function () {
			URL.revokeObjectURL(output2.src)
		}
	}

	function hideButton()
	{
		$("#btn").attr('disabled',true);
	}
</script>
@endsection