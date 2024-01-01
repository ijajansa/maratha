@extends('layouts.app')
@section('content')
<style type="text/css">
	.card-bordered{
		width: 50%;
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
								<h4 class="title nk-block-title">Add New Model</h4>

							</div>
						</div>
						<div class="card card-bordered">
							<div class="card-inner">

								<form method="post" enctype="multipart/form-data" action="{{url('models/add')}}">
									<input type="hidden" name="_token" value="{{csrf_token()}}">
									<div class="row g-4">
										<div class="col-lg-12">
											<label for="exampleFormControlInput1" class="form-label text-primary">Brand Name <span class="required">*</span></label>
											<select class="form-control @error('brand_id') is-invalid @enderror" name="brand_id">
												<option value="">Select</option>
												@foreach($brands as $brand)
												<option value="{{$brand->id}}" @if(old('brand_id')==$brand->id) selected @endif>{{$brand->brand_name}}</option>
												@endforeach
											</select>
											@error('brand_id')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror
										</div>
										
										<div class="col-xl-12 col-sm-12">
											<label for="exampleFormControlInput1" class="form-label text-primary">Model Name <span class="required">*</span></label>
											<input type="text" class="form-control @error('model_name') border-danger @enderror" id="exampleFormControlInput1" value="{{old('model_name')}}" placeholder="Enter Model Name" name="model_name">
											@error('model_name')
											<div class="mt-2 text-danger">{{ $message }}</div>
											@enderror
										</div>


										<div class="col-12">
											<div class="form-group">
												<button type="submit" class="btn btn-lg btn-primary">Save Details</button>
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
</script>
@endsection