@extends('layouts.app')
<style>
	.form-group{
		margin-bottom: 8px !important;
	}
	.form-label{
		margin-bottom: 0.5px !important;
	}
</style>
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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
								<h4 class="nk-block-title">सभासद तपशील अद्यतनित करा</h4>

							</div>
						</div>
						<div class="card card-bordered">
							<div class="card-inner">

								<form method="post" enctype="multipart/form-data" action="{{url('users/edit')}}/{{$data->id}}">
									<input type="hidden" name="_token" value="{{csrf_token()}}">
									<div class="row g-4">

										<div class="col-lg-4">
											<img @if($data->profile_image!=null) src="{{url('storage/app')}}/{{$data->profile_image}}" @else src="{{asset('assets/images/default.svg')}}" @endif id="output" style="width:150px;height:150px">
											<br>
											<label for="imageUpload" class="form-label text-primary">Profile Image <span class="required">*</span></label>
											<input type="file" class="form-control form-control-sm @error('image') is-invalid @enderror" id="imageUpload" value="{{old('image')}}" name="image" onchange="showImagePreview(event)" accept=".png, .jpg, .jpeg">
											@error('image')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror
										</div>
										<div class="col-lg-8">
											<div class="form-group">
												<label for="exampleFormControlInput1" class="form-label text-primary">सभासदाचे नाव <span class="required">*</span></label>
												<input type="text" class="form-control form-control-sm @error('name') is-invalid @enderror" id="exampleFormControlInput1" value="{{old('name',$data->name)}}" placeholder="Enter Full Name" name="name">
												@error('name')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
												@enderror
											</div>
											<div class="form-group">
												<label for="exampleFormControlInput1" class="form-label text-primary">वय <span class="required">*</span></label>
												<input type="number" min="18" class="form-control form-control-sm @error('age') is-invalid @enderror" id="exampleFormControlInput1" value="{{old('age',$data->age)}}" placeholder="Enter Age" name="age">
												@error('age')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
												@enderror
											</div>
											<div class="form-group">
												<label for="exampleFormControlInput6" class="form-label text-primary">मोबाईल क्र. <span class="required">*</span></label>
												<input type="number" class="form-control form-control-sm @error('mobile_number') is-invalid @enderror" id="exampleFormControlInput6" value="{{old('mobile_number',$data->mobile_number)}}" placeholder="Enter Contact Number" name="mobile_number">
												@error('mobile_number')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
												@enderror
											</div>
											<div class="form-group">
												<label for="exampleFormControlInput1" class="form-label text-primary">आधार कार्ड क्र. <span class="required">*</span></label>
												<input type="number" class="form-control form-control-sm @error('aadhaar_card_number') is-invalid @enderror" id="exampleFormControlInput1" value="{{old('aadhaar_card_number',$data->aadhaar_card_number)}}" placeholder="Enter Aadhar Number" name="aadhaar_card_number">
												@error('aadhaar_card_number')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
												@enderror
											</div>

											<div class="form-group">
												<label for="exampleFormControlInput1" class="form-label text-primary">सध्याचा पत्ता वार्ड क्र. सह</label>
												<input type="text" name="current_address" class="form-control form-control-sm @error('current_address') is-invalid @enderror" placeholder="Enter Current Address" value="{{old('current_address',$data->current_address)}}">
												@error('current_address')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
												@enderror
											</div>
										</div>
										
										
										<div class="col-lg-12">

											<div class="form-group">
												<label for="exampleFormControlInput1" class="form-label text-primary">कायमचा पत्ता वार्ड क्र. सह												</label>
												<input type="text" class="form-control form-control-sm  @error('permanent_address') is-invalid @enderror" name="permanent_address" placeholder="Enter Permanent Address" value="{{old('permanent_address',$data->permanent_address)}}">
												@error('permanent_address')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
												@enderror
											</div>
											<div class="form-group">
												<label for="exampleFormControlInput1" class="form-label text-primary">व्यवसाय <span class="required">*</span></label>
												<input type="text" class="form-control form-control-sm @error('profession') is-invalid @enderror" id="exampleFormControlInput1" value="{{old('profession',$data->profession)}}" placeholder="Enter Aadhar Number" name="profession">
												@error('profession')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
												@enderror
											</div>

											<div class="form-group">
												<label for="exampleFormControlInput1" class="form-label text-primary">शेती व पिक माहिती <span class="required">*</span></label>
												<input type="text" class="form-control @error('farm') is-invalid @enderror" id="exampleFormControlInput1" value="{{old('farm',$data->farm)}}" placeholder="Enter Aadhar Number" name="farm">
												@error('farm')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
												@enderror
											</div>
										</div>
										<div class="col-lg-12">
											<div class="form-group">
												<label for="exampleFormControlInput1" class="form-label text-primary">कुटुंब सदस्य माहिती : - (महिला व मुलींचे मोबाईल क्र. नोंद करू नयेत) <span class="required">*</span></label>
												<table class="table table-bordered mt-2">
													<tr>
														<thead>
															<th>अ.क्र</th>
															<th>सदस्याचे नाव</th>
															<th>वय</th>
															<th>नाते</th>
															<th>व्यवसाय/ शिक्षण</th>
															<th>मोबाईल क्र.</th>
															<th>आधार कार्ड क्र.</th>
														</thead>
													</tr>
													@if($data->family)
													@foreach($data->family as $key=> $family)
													<tr>
														<td>{{++$key}}</td>
														<td>{{$family->family_member_name??''}}</td>
														<td>{{$family->family_member_age??''}}</td>
														<td>{{$family->family_member_relation??''}}</td>
														<td>{{ $family->family_member_profession." / ".$family->family_member_education??''}}</td>
														<td>{{$family->family_member_mobile_number??''}}</td>
														<td>{{$family->family_member_aadhaar_card_number??''}}</td>

													</tr>
													@endforeach
													@endif
												</table>
											</div>
										</div>	
										<div class="col-lg-12">	
											<div class="form-group">
												<label for="exampleFormControlInput1" class="form-label text-primary">समस्या</label>
												<input type="text" class="form-control form-control-sm @error('issue') is-invalid @enderror" id="exampleFormControlInput1" value="{{old('issue',$data->issue)}}" placeholder="Enter Aadhar Number" name="issue">
												@error('issue')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
												@enderror
											</div>

											<div class="form-group">
												<label for="exampleFormControlInput1" class="form-label text-primary">संघाकडून अपेक्षा</label>
												<input type="text" class="form-control @error('exception') is-invalid @enderror" id="exampleFormControlInput1" value="{{old('exception',$data->exception)}}" placeholder="Enter Aadhar Number" name="exception">
												@error('exception')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
												@enderror
											</div>

											{{-- <div class="form-group">
												<label for="exampleFormControlInput1" class="form-label text-primary">Education <span class="required">*</span></label>
												<input type="text" class="form-control @error('education') is-invalid @enderror" id="exampleFormControlInput1" value="{{old('education',$data->education)}}" placeholder="Enter Aadhar Number" name="education">
												@error('education')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
												@enderror
											</div> --}}
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