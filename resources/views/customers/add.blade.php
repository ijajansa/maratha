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
								<h4 class="title nk-block-title">Add New User</h4>

							</div>
						</div>
						<div class="card card-bordered">
							<div class="card-inner">

								<form method="post" enctype="multipart/form-data" action="{{url('users/add')}}">
									<input type="hidden" name="_token" value="{{csrf_token()}}">
									<div class="row g-4">

										<div class="col-lg-6">
											<div class="form-group">
												<label for="exampleFormControlInput1" class="form-label text-primary">Full Name <span class="required">*</span></label>
												<input type="text" class="form-control @error('name') is-invalid @enderror" id="exampleFormControlInput1" value="{{old('name')}}" placeholder="Enter Full Name" name="name">
												@error('name')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
												@enderror
											</div>
										</div>
										<div class="col-xl-6 col-sm-6">
											<label for="exampleFormControlInput3" class="form-label text-primary">Email Address<span class="required">*</span></label>
											<input type="email" class="form-control @error('email') is-invalid @enderror" id="exampleFormControlInput3" value="{{old('email')}}" placeholder="Enter Email Address" name="email">
											@error('email')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror
										</div>
										<div class="col-xl-6 col-sm-6">
											<label for="exampleFormControlInput6" class="form-label text-primary">Contact Number <span class="required">*</span></label>
											<input type="number" class="form-control @error('contact_number') is-invalid @enderror" id="exampleFormControlInput6" value="{{old('contact_number')}}" placeholder="Enter Contact Number" name="contact_number">
											@error('contact_number')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror
										</div>
										<div class="col-xl-6 col-sm-6">
											<label for="search_input" class="form-label text-primary">Address <span class="required">*</span></label>
											<input type="text" class="form-control @error('address') is-invalid @enderror" id="search_input" autocomplete="off" placeholder="Enter Address" name="address" onchange="getLatLang(this.value)" onselect="getLatLang(this.value)">
											@error('address')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror
										</div>
										<div class="col-xl-6 col-sm-6">
											<label for="exampleFormControlInput9" class="form-label text-primary">Password <span class="required">*</span></label>
											<input type="password" class="form-control @error('password') is-invalid @enderror" id="exampleFormControlInput9" placeholder="Enter Password" name="password" value="{{old('password')}}">
											@error('password')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror
										</div>

										<div class="col-xl-6 col-sm-6">
											<label for="exampleFormControlInput10" class="form-label text-primary">Upload Identity Proof <span class="required">*</span></label>
											<input type="file" class="form-control @error('image') is-invalid @enderror" id="imageUpload" placeholder="Upload Document" name="image" onchange="showImagePreview(event)">
											<span>Upload aadhar card/PAN card or driving license</span>
											@error('image')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror
												<div class="mt-3">
													
											<img src="{{asset('assets/images/default.svg')}}" width="90px" height="90px" id="output">
												</div>
										</div>
											<input type="hidden" name="lat" id="lat">
											<input type="hidden" name="lng" id="lng">
										<!-- <div class="col-xl-6 col-sm-6">
												<img src="{{asset('assets/images/default.svg')}}" id="output" style="width:90px;height:90px">
											</div> -->

											<div class="col-xl-12">
												<div class="form-group">
													<button type="submit" class="btn btn-lg btn-primary">Save Details</button>
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