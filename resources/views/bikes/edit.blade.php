@extends('layouts.app')
@section('content')
<style type="text/css">
	.gallery img{
		width: 140px;
		height: 140px;
		margin-right: 30px
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
								<h4 class="title nk-block-title">Update Bike Details</h4>

							</div>
						</div>
						<div class="card card-bordered">
							<div class="card-inner">

								<form method="post" enctype="multipart/form-data" action="{{url('bikes/edit')}}/{{$data->id}}">
									<input type="hidden" name="_token" value="{{csrf_token()}}">
									<div class="row g-4">

										
										<div class="col-lg-4">
											<div class="form-group">
												<label class="form-label text-primary">Brand Name <span class="required">*</span></label>
												<div class="form-control-wrap">
													<select class="form-control @error('brand_id') is-invalid @enderror" name="brand_id" onchange="getModel(this.value)" id="brand_id">
														<option value="">Select Brand</option>
														@foreach($brands as $brand)
														<option value="{{$brand->id}}" @if(old('brand_id',$data->brand_id)==$brand->id) selected @endif>{{$brand->brand_name}}</option>
														@endforeach
													</select>
													@error('brand_id')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
													@enderror
												</div>
											</div>
										</div>
										<div class="col-lg-4">
											<div class="form-group">
												<label class="form-label text-primary">Category Name <span class="required">*</span></label>
												<div class="form-control-wrap">
													<select class="form-control @error('category_id') is-invalid @enderror" name="category_id">
														<option value="">Select Category</option>
														@foreach($categories as $category)
														<option value="{{$category->id}}" @if(old('category_id',$data->category_id)==$category->id) selected @endif>{{$category->category_name}}</option>
														@endforeach
													</select>
													@error('category_id')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
													@enderror
												</div>
											</div>
										</div>
										
										<div class="col-lg-4">
											<div class="form-group">
												<label class="form-label text-primary">Model Name <span class="required">*</span></label>
												<div class="form-control-wrap">
													<select class="form-control @error('model_id') is-invalid @enderror" name="model_id" id="model_id">
														<option value="">Select Model</option>
														@foreach($models as $model)
														<option value="{{$model->id}}" @if(old('model_id',$data->model_id)==$model->id) selected @endif>{{$model->model_name}}</option>
														@endforeach
													</select>
													@error('model_id')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
													@enderror
												</div>
											</div>
										</div>
										<div class="col-lg-4">
											<div class="form-group">
												<label for="" class="form-label text-primary">Vehicle Registration Number <span class="required">*</span></label>
												<div class="form-control-wrap">
													<input type="text" id="demo-text-input" name="registration_number" class="form-control form-control-md @error('registration_number') is-invalid @enderror" placeholder="Enter Vehicle Registration Number" value="{{old('registration_number',$data->registration_number)}}" />
													@error('registration_number')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
													@enderror
												</div>
											</div>
										</div>
										<div class="col-lg-4">
											<div class="form-group">
												<label class="form-label text-primary">Registration Year <span class="required">*</span></label>
												<div class="form-control-wrap">
													<select class="form-control @error('registration_year_id') is-invalid @enderror" name="registration_year_id" >
														<option value="">Select Registration Year</option>
														@foreach($years as $year)
														<option value="{{$year->id}}" @if(old('registration_year_id',$data->registration_year_id)==$year->id) selected @endif>{{$year->year}}</option>
														@endforeach
													</select>
													@error('registration_year_id')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
													@enderror
												</div>
											</div>
										</div>
										<div class="col-lg-4">
											<div class="form-group">
												<label for="" class="form-label text-primary">Vehicle Chassis Number</label>
												<div class="form-control-wrap">
													<input type="text" id="demo-text-input" name="chassis_number" class="form-control form-control-md @error('chassis_number') is-invalid @enderror" placeholder="Enter Vehicle Chassis Number" value="{{old('chassis_number',$data->chassis_number)}}" />
													@error('chassis_number')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
													@enderror
												</div>
											</div>
										</div>
										
										<div class="col-lg-4">
											<div class="form-group">
												<label for="" class="form-label text-primary">Vehicle Engine Number</label>
												<div class="form-control-wrap">
													<input type="text" id="demo-text-input" name="engine_number" class="form-control form-control-md @error('engine_number') is-invalid @enderror" placeholder="Enter Vehicle Engine Number" value="{{old('engine_number',$data->engine_number)}}" />
													@error('engine_number')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
													@enderror
												</div>
											</div>
										</div>
										@if(Auth::user()->role_id == 1)
										<div class="col-lg-4">
											<div class="form-group">
												<label class="form-label text-primary">Store Name <span class="required">*</span></label>
												<div class="form-control-wrap">
													<select class="form-control form-select @error('store_id') is-invalid @enderror" data-search="on" data-placeholder="Select Store" name="store_id">
														<option value="">Select Store</option>
														@foreach($stores as $store)
														<option value="{{$store->id}}" @if($data->store_id == $store->id) selected @endif>{{$store->store_name}}</option>
														@endforeach
													</select>
													@error('store_id')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
													@enderror
												</div>
											</div>
										</div>
										@else
										<input type="hidden" name="store_id" value="{{Auth::user()->store_id}}">
										@endif
										<div class="col-xl-12 col-sm-12">
											<hr>
										</div>
										<div class="col-lg-4">
											<div class="preview-block">
												<span class="preview-title overline-title">PUC Available</span>
												<div class="custom-control custom-switch checked">
													<input type="checkbox" name="is_puc" class="custom-control-input" @if($data->is_puc==1) checked="" @endif id="customSwitch2">
													<label class="custom-control-label" for="customSwitch2"></label>
												</div>
											</div>
											<label class="form-label text-primary">Upload PUC</label>
											<input type="file" name="puc_image" class="form-control @error('puc_image') is-invalid @enderror">
											@error('puc_image')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror
											@if($data->puc_image!=null)
											<img src="{{url('storage/app')}}/{{$data->puc_image}}" style="width:70px;height:70px;margin-top:10px">
											@endif
										</div>
										<div class="col-lg-4">
											<div class="preview-block">
												<span class="preview-title overline-title">Insurance Available</span>
												<div class="custom-control custom-switch checked">
													<input type="checkbox" name="is_insurance" class="custom-control-input" @if($data->is_insurance==1) checked="" @endif id="customSwitch3">
													<label class="custom-control-label" for="customSwitch3"></label>
												</div>
											</div>
											<label class="form-label text-primary">Upload Insurance</label>
											<input type="file" name="insurance_image" class="form-control @error('insurance_image') is-invalid @enderror">
											@error('insurance_image')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror
											@if($data->insurance_image!=null)
											<img src="{{url('storage/app')}}/{{$data->insurance_image}}" style="width:70px;height:70px;margin-top:10px">
											@endif
										</div>
										
										<div class="col-lg-4">
											<div class="preview-block">
												<span class="preview-title overline-title">Documents Available</span>
												<div class="custom-control custom-switch checked">
													<input type="checkbox" name="is_document" class="custom-control-input" @if($data->is_documents==1) checked="" @endif id="customSwitch4">
													<label class="custom-control-label" for="customSwitch4"></label>
												</div>
											</div>
											<label class="form-label text-primary">Upload Document</label>
											<input type="file" name="document_image" class="form-control @error('document_image') is-invalid @enderror">
											@error('document_image')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror
											@if($data->document_image!=null)
											<img src="{{url('storage/app')}}/{{$data->document_image}}" style="width:70px;height:70px;margin-top:10px">
											@endif
										</div>
										<div class="col-xl-12 col-sm-12">
											<label for="imageUpload" class="form-label text-primary">Upload Vehicle Images <span class="required">*</span></label>
											<input type="file" class="form-control" id="imageUpload" name="image[]" multiple  accept=".png, .jpg, .jpeg">
											<!-- @error('image')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror -->
											<div class="mt-3">
												<div class="gallery">
													
												</div>
											</div>
											<div class="row">
												@if($images)
												@foreach($images as $image)
												<div class="col-lg-3">
													<img src="{{url('storage/app')}}/{{$image->images}}" style="width: 100%;height: 180px"><button type="button" onclick="deleteImage({{$image->id}})" class="btn btn-block btn-danger mt-2"><i class="icon ni ni-trash"></i></button>
												</div>
												@endforeach
												@endif
											</div>
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
	$(function() {
    // Multiple images preview in browser
    var imagesPreview = function(input, placeToInsertImagePreview) {

    	if (input.files) {
    		var filesAmount = input.files.length;

    		for (i = 0; i < filesAmount; i++) {
    			var reader = new FileReader();

    			reader.onload = function(event) {
    				$($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
    			}

    			reader.readAsDataURL(input.files[i]);
    		}
    	}

    };

    $('#imageUpload').on('change', function() {
    	imagesPreview(this, 'div.gallery');
    });
});
</script>
<script type="text/javascript">
	function getBrand(category_id)
	{
		if(category_id.length!=0)
		{
			$.ajax({
				url:"{{url('get-brands')}}",
				type:"GET",
				data:{category_id:category_id},
				success:function(data)
				{
					$("#brand_id").html(data);
					$('#model_id option:eq(1)').prop('selected', true);
				} 
			});
		}
	}
	function getModel(brand_id)
	{
		if(brand_id.length!=0)
		{
			$.ajax({
				url:"{{url('get-models')}}",
				type:"GET",
				data:{brand_id:brand_id},
				success:function(data)
				{
					$("#model_id").html(data);
				} 
			});
		}
	}
</script>
<script type="text/javascript">
	function deleteImage(id)
	{
		if(confirm("Are you sure want to delete ?"))
		{
			window.location.href="{{url('bikes/delete')}}/"+id;
		}
	}
</script>
@endsection