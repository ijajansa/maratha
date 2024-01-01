@extends('layouts.app')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Google Maps JavaScript library -->
<script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDhfn57U4mBVZiNp6-UBxeMXIrSdA8jYmE&callback=initMap&libraries=places&v=weekly"
      defer
    ></script>

<style type="text/css">

	/*.card-bordered{
		width: 100%;
	}
	@media(max-width: 600px)
	{
		.card-bordered{
			width: 100%;
		}	
	}*/
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
								<h4 class="title nk-block-title">Update Store Details</h4>

							</div>
						</div>
						<div class="card card-bordered">
							<div class="card-inner">

								<form method="post" enctype="multipart/form-data" action="{{url('stores/edit')}}/{{$data->id}}">
									<input type="hidden" name="_token" value="{{csrf_token()}}">
									<div class="row g-4">

										<div class="col-lg-6">
											<div class="form-group">
												<label for="exampleFormControlInput1" class="form-label text-primary">Store Name <span class="required">*</span></label>
												<input type="text" class="form-control @error('store_name') is-invalid @enderror" id="exampleFormControlInput1" value="{{old('store_name',$data->store_name)}}" placeholder="Enter Store Name" name="store_name">
												@error('store_name')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
												@enderror
											</div>
										</div>
								
										<div class="col-xl-6 col-sm-6">
											<label for="exampleFormControlInput6" class="form-label text-primary">Store Contact Number <span class="required">*</span></label>
											<input type="number" class="form-control @error('store_contact_number') is-invalid @enderror" id="exampleFormControlInput6" value="{{old('store_contact_number',$data->store_contact_number)}}" placeholder="Enter Contact Number" name="store_contact_number">
											@error('store_contact_number')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror
										</div>
										
										<!--<div class="col-xl-6 col-sm-6">-->
										<!--	<label for="exampleFormControlInput6" class="form-label text-primary">Store GSTIN Number <span class="required">*</span></label>-->
										<!--	<input type="text" class="form-control @error('store_gstin_number') is-invalid @enderror" id="exampleFormControlInput6" value="{{old('store_gstin_number',$data->store_gstin_number)}}"  placeholder="Enter GSTIN Number" name="store_gstin_number">-->
										<!--	@error('store_gstin_number')-->
										<!--	<span class="invalid-feedback" role="alert">-->
										<!--		<strong>{{ $message }}</strong>-->
										<!--	</span>-->
										<!--	@enderror-->
										<!--</div>-->
										
										<div class="col-xl-6 col-sm-6">
											<label for="search_input" class="form-label text-primary">Address <span class="required">*</span></label>
											<input type="text" class="form-control @error('address') is-invalid @enderror" value="{{$data->store_address}}" id="search_input" autocomplete="off" placeholder="Enter Address" name="address" onkeyup="getLatLang(this.value)" onselect="getLatLang(this.value)">
											@error('address')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror
										</div>
										
										<div class="col-xl-6 col-sm-6">
											<label for="search_input1" class="form-label text-primary">Store Google Map URL <span class="required">*</span></label>
											<input type="text" class="form-control @error('store_url') is-invalid @enderror" id="search_input1" value="{{old('store_url',$data->store_url)}}" autocomplete="off" placeholder="Enter Google Map URL" name="store_url">
											@error('store_url')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror
										</div>
										
										<div class="col-xl-6 col-sm-6">
											<label for="exampleFormControlInput10" class="form-label text-primary">Store Image <span class="required">*</span></label>
											<input type="file" class="form-control @error('image') is-invalid @enderror" id="imageUpload" placeholder="Upload Document" name="image" onchange="showImagePreview(event)">
											@error('image')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror
												<div class="mt-3">
											@if($data->store_image == null)
											<img src="{{asset('assets/images/default.svg')}}" width="90px" height="90px" id="output">
											@else
											<a href="{{url('storage/app')}}/{{$data->store_image}}" target="_blank">
												<img src="{{url('storage/app')}}/{{$data->store_image}}" width="90px" height="90px" id="output">
											</a>
			
											@endif
											</div>
										</div>
											<input type="hidden" name="lat" id="lat" value="{{$data->store_latitude}}">
											<input type="hidden" name="lng" id="lng" value="{{$data->store_longitude}}">
										<!-- <div class="col-xl-6 col-sm-6">
												<img src="{{asset('assets/images/default.svg')}}" id="output" style="width:90px;height:90px">
											</div> -->

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

<script>
var searchInput = 'search_input';
 
$(document).ready(function () {
 var autocomplete;
 autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {
  types: ['geocode'],
  /*componentRestrictions: {
   country: "USA"
  }*/
 });
  
 google.maps.event.addListener(autocomplete, 'place_changed', function () {
  var near_place = autocomplete.getPlace();
 });
});
</script>

<script type="text/javascript">
function getLatLang(address)
{
	var form = new FormData();
	var settings = {
		"url": "https://maps.googleapis.com/maps/api/geocode/json?address="+address+"&key=AIzaSyDhfn57U4mBVZiNp6-UBxeMXIrSdA8jYmE",
		"method": "GET",
		"timeout": 0,
		"processData": false,
		"mimeType": "multipart/form-data",
		"contentType": false,
		"data": form
	};

	$.ajax(settings).done(function (response) {
		response = JSON.parse(response);
		$("#lat").val(response['results'][0]['geometry']['location']['lat']);
		$("#lng").val(response['results'][0]['geometry']['location']['lng']);
	});
}
</script>
@endsection