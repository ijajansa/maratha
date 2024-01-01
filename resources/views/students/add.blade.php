@extends('layouts.app')
@section('title', 'Add New Student')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-xl-12">
			<div class="card">
				<div class="card-header">
					<h5 class="mb-0">Personal Details</h5>
				</div>
				<div class="card-body">
					<form method="POST" action="{{url('students/add')}}"  enctype="multipart/form-data">
						@csrf
						<div class="row">
						    
							<div class="col-xl-6 col-sm-6">
								<div class="mb-3">
									<label for="exampleFormControlInput1" class="form-label text-primary">Full Name <span class="required">*</span></label>
									<input type="text" class="form-control form-control-sm @error('name') is-invalid @enderror" id="exampleFormControlInput1" value="{{old('name')}}" placeholder="Enter Full Name" name="name">
									@error('name')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
							</div>
							<div class="col-xl-6 col-sm-6">

								<div class="mb-3">
									<label for="exampleFormControlInput3" class="form-label text-primary">Email Address <span class="required">*</span></label>
									<input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror" id="exampleFormControlInput3" value="{{old('email')}}" placeholder="Enter Email Address" name="email">
									@error('email')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>

							</div>
							<div class="col-xl-6 col-sm-6">

								<div class="mb-3">
									<label for="exampleFormControlInput6" class="form-label text-primary">Contact Number <span class="required">*</span></label>
									<input type="number" class="form-control form-control-sm @error('contact_number') is-invalid @enderror" id="exampleFormControlInput6" value="{{old('contact_number')}}" placeholder="Enter Contact Number" name="contact_number">
									@error('contact_number')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
							</div>
							<div class="col-xl-6 col-sm-6">
								<div class="mb-3">
									<label for="exampleFormControlInput7" class="form-label text-primary">Parent Contact Number <span class="required">*</span></label>
									<input type="number" class="form-control form-control-sm @error('parent_contact_number') is-invalid @enderror" id="exampleFormControlInput7" value="{{old('parent_contact_number')}}" placeholder="Enter Parent Contact Number" name="parent_contact_number">
									@error('parent_contact_number')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
							</div>

							<div class="col-xl-6 col-sm-6">
								<div class="mb-3">
									<label class="form-label text-primary">Gender <span class="required">*</span></label>
									<div class="d-flex align-items-center">
										<div class="form-check">
											<input class="form-check-input" type="radio" name="gender" value="Male" checked @if(old('gender'=='Male')) checked @endif id="flexCheckDefault">
											<label class="form-check-label font-w500" for="flexCheckDefault">
												Male
											</label>
										</div>
										<div class="form-check ms-3">
											<input class="form-check-input" type="radio" name="gender" value="Female" @if(old('gender'=='Female')) checked @endif id="flexCheckDefault1">
											<label class="form-check-label font-w500" for="flexCheckDefault1">
												Female
											</label>
										</div>

									</div>
								</div>
							</div>

							<div class="col-xl-6 col-sm-6">
								<div class="mb-3">
									<label for="exampleFormControlInput7" class="form-label text-primary">College Name <span class="required">*</span></label>
									<input type="text" class="form-control form-control-sm @error('college_name') is-invalid @enderror" id="exampleFormControlInput7" value="{{old('college_name')}}" placeholder="Enter College Name" name="college_name">
									@error('college_name')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
							</div>

							<div class="col-xl-6 col-sm-6">
								<div class="mb-3">
									<label class="form-label">Payment Type <span class="required">*</span></label>
									<div class="dropdown bootstrap-select default-select form-control wide">
										<select id="inputState" name="payment_type" class="default-select form-control form-control-sm wide @error('payment_type') is-invalid @enderror" tabindex="null">
											<option value="google_pay" @if(old('payment_type'=='google_pay')) selected @endif>Google Pay</option>
											<option value="phone_pay" @if(old('payment_type'=='phone_pay')) selected @endif>Phone Pay</option>
											<option value="cash" @if(old('payment_type'=='cash')) selected @endif>Cash</option>
										</select>
									</div>
									@error('payment_type')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
								<div class="mb-3">
								    <label class="form-label text-primary">Photo<span class="required">*</span></label>
										 <div class="avatar-upload">
											<div class="avatar-preview">
												<div id="imagePreview" style=""> 	
												<img src="{{asset('assets/images/no-img-avatar.png')}}" id="output" style="width:90px;height:90px">
												</div>
											</div>
											<div class="change-btn mt-2 mb-lg-0 mb-3">
												<input type="file" class="form-control d-none" id="imageUpload" name="profile_photo" onchange="showImagePreview(event)" accept=".png, .jpg, .jpeg">
												<label for="imageUpload" class="dlab-upload mb-0 btn btn-primary btn-sm">Choose File</label>
											</div>
										</div>	
								</div>
							</div>

							<div class="col-xl-6 col-sm-6">
								<div class="mb-3">
									<label for="exampleFormControlTextarea1" class="form-label text-primary">Address <span class="required">*</span></label>
									<textarea class="form-control @error('address') is-invalid @enderror" name="address" id="exampleFormControlTextarea1" placeholder="Address" rows="6">{{old('address')}}</textarea>
									@error('address')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
							</div>
							
						</div>
						<div class="float-end">
							<button class="btn btn-primary" type="submit">Save Details</button>
						</div>

					</form>
				</div>
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