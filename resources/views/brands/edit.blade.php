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
								<h4 class="title nk-block-title">Update Brand Details</h4>

							</div>
						</div>
						<div class="card card-bordered">
							<div class="card-inner">

								<form method="post" enctype="multipart/form-data" action="{{url('brands/edit')}}/{{$record->id}}">
									<input type="hidden" name="_token" value="{{csrf_token()}}">
									<div class="row g-4">
										<!--<div class="col-lg-12">-->
										<!--	<label for="exampleFormControlInput1" class="form-label text-primary">Category Name <span class="required">*</span></label>-->
										<!--	<select class="form-control @error('category_id') is-invalid @enderror" name="category_id">-->
										<!--		<option value="">Select</option>-->
										<!--		@foreach($data as $category)-->
										<!--		<option value="{{$category->id}}" @if(old('category_id',$record->category_id)==$category->id) selected @endif>{{$category->category_name}}</option>-->
										<!--		@endforeach-->
										<!--	</select>-->
										<!--	@error('category_id')-->
										<!--	<span class="invalid-feedback" role="alert">-->
										<!--		<strong>{{ $message }}</strong>-->
										<!--	</span>-->
										<!--	@enderror-->
										<!--</div>-->
										<div class="col-lg-12">
											<div class="form-group">
												<label for="imageUpload" class="form-label text-primary">Brand Name <span class="required">*</span></label>
												<div class="form-control-wrap">
													<input type="text" id="demo-text-input" name="brand_name" class="form-control form-control-md @error('brand_name') is-invalid @enderror" placeholder="Enter Brand Name" value="{{old('brand_name',$record->brand_name)}}" />
													@error('brand_name')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
													@enderror
												</div>
											</div>
										</div>

										<div class="col-xl-12 col-sm-12">
											<label for="imageUpload" class="form-label text-primary">Image <span class="required">*</span></label>
											<input type="file" class="form-control @error('image') is-invalid @enderror" id="imageUpload" value="{{old('image')}}" name="image" onchange="showImagePreview(event)" accept=".png, .jpg, .jpeg">
											@error('image')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror

										</div>

										<div class="col-xl-12 col-sm-12">
											<img @if($record->brand_image!=null) src="{{url('storage/app')}}/{{$record->brand_image}}" @else src="{{asset('assets/images/default.svg')}}" @endif id="output" style="width:90px;height:90px">
										</div>

										<div class="col-12">
											<div class="form-group">
												<button type="submit" class="btn btn-lg btn-primary">Update Details</button>
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