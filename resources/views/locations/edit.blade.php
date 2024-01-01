@extends('layouts.app')
@section('content')

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
									<h4 class="title nk-block-title">Update Location Details</h4>

								</div>
							</div>
							<div class="card card-bordered">
								<div class="card-inner">

									<form method="post" action="{{url('locations/edit')}}/{{$data->id}}">
										<input type="hidden" name="_token" value="{{csrf_token()}}">
										<div class="row g-4">
											<div class="col-xl-6 col-sm-6">
												<label for="search_input" class="form-label text-primary">Address <span class="required">*</span></label>
												<input type="text" class="form-control @error('address') is-invalid @enderror" id="search_input" autocomplete="off" placeholder="Enter Address" name="address" value="{{old('address',$data->address)}}">
												@error('address')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
												@enderror
											</div>

											<div class="col-xl-6 col-sm-6">
												<label for="search_input1" class="form-label text-primary">Latitude <span class="required">*</span></label>
												<input type="text" class="form-control @error('latitude') is-invalid @enderror" id="search_input1" autocomplete="off" placeholder="Enter Latitude" name="latitude" value="{{old('latitude',$data->latitude)}}">
												@error('latitude')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
												@enderror
											</div>

											<div class="col-xl-6 col-sm-6">
												<label for="search_input2" class="form-label text-primary">Longitude <span class="required">*</span></label>
												<input type="text" class="form-control @error('longitude') is-invalid @enderror" id="search_input2" autocomplete="off" placeholder="Enter Longitude" name="longitude" value="{{old('longitude',$data->longitude)}}">
												@error('longitude')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
												@enderror
											</div>

											<div class="col-xl-12">
												<div class="form-group">
													<button type="submit" class="btn btn-lg btn-primary">Update Details</button>
												</div>
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


@endsection