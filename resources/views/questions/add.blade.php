@extends('layouts.app')
@section('title', 'Add New Question')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-xl-12">
			<div class="card">
				<div class="card-header">
					<h5 class="mb-0">Question Details</h5>
				</div>
				<div class="card-body">
					<form method="POST" action="{{url('mcq-questions/add')}}"  enctype="multipart/form-data">
						@csrf
						<div class="row">
							<div class="col-xl-12 col-sm-12">
								<div class="mb-3">
									<label for="exampleFormControlInput3" class="form-label text-primary">Select Chapter <span class="required">*</span></label>
									<select class="form-control @error('chapter_id') is-invalid @enderror" name="chapter_id">
										<option value="">Select</option>
										@foreach($chapters as $chapter)
										<option value="{{$chapter->id}}">{{$chapter->name}} - {{$chapter->subject_name}} - {{$chapter->standard_name}}</option>
										@endforeach
									</select>
									@error('chapter_id')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>

							</div>
							<div class="col-xl-6 col-sm-6">
								<div class="mb-3">
									<label for="exampleFormControlInput1" class="form-label text-primary">Question Text <span class="required">*</span></label>
									<textarea class="form-control @error('question_text') is-invalid @enderror" placeholder="Question Text" rows="4" name="question_text" id="exampleFormControlInput1">{{old('question_text')}}</textarea>

									@error('question_text')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
							</div>
							<div class="col-xl-6 col-sm-6">
								<div class="mb-3">
									<label class="form-label text-primary">Question Image <span class="required">*</span></label>
									<div class="avatar-upload">
										<div class="avatar-preview">
											<div id="imagePreview" style=""> 	
												<img src="{{asset('assets/images/no-img.svg')}}" id="output" style="width:90px;height:90px">
											</div>
										</div>
										<div class="change-btn mt-2 mb-lg-0 mb-3">
											<input type="file" class="form-control d-none" id="imageUpload" name="question_image" onchange="showImagePreview(event)" accept=".png, .jpg, .jpeg">
											<label for="imageUpload" class="dlab-upload mb-0 btn btn-primary btn-sm">Choose File</label>
										</div>
									</div>
								</div>

							</div>
							<div class="col-lg-12">
								<hr>
							</div>
							<div class="col-xl-6 col-sm-6">
								<div class="mb-3">
									<label class="form-label text-primary">Option 1 <span class="required">*</span></label>
									<div class="d-flex align-items-center">
										<div class="form-check">
											<input class="form-check-input" type="radio" name="option1_type" value="0" checked @if(old('option1_type'=='0')) checked @endif id="flexCheckDefault">
											<label class="form-check-label font-w500" for="flexCheckDefault">
												Text
											</label>
										</div>
										<div class="form-check ms-3">
											<input class="form-check-input" type="radio" name="option1_type" value="1" @if(old('option1_type'=='1')) checked @endif id="flexCheckDefault1">
											<label class="form-check-label font-w500" for="flexCheckDefault1">
												Image
											</label>
										</div>
									</div>
								</div>
								<div class="mb-3">
									<label for="exampleFormControlInput6" class="form-label text-primary">Text <span class="required">*</span></label>
									<textarea class="form-control @error('option1') is-invalid @enderror" rows="4" placeholder="Enter option 1 text" name="option1">{{old('option1')}}</textarea>

									@error('option1')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
								<div class="mb-3">
									<label class="form-label text-primary">Image <span class="required">*</span></label>
									<div class="avatar-upload">
										<div class="avatar-preview">
											<div id="imagePreview" style=""> 	
												<img src="{{asset('assets/images/no-img.svg')}}" id="output1" style="width:90px;height:90px">
											</div>
										</div>
										<div class="change-btn mt-2 mb-lg-0 mb-3">
											<input type="file" class="form-control d-none" id="imageUpload1" name="option1_image" onchange="showImagePreview1(event)" accept=".png, .jpg, .jpeg">
											<label for="imageUpload1" class="dlab-upload mb-0 btn btn-primary btn-sm">Choose File</label>
										</div>
									</div>
								</div>
							</div>
							
							<div class="col-xl-6 col-sm-6">
								<div class="mb-3">
									<label class="form-label text-primary">Option 2 <span class="required">*</span></label>
									<div class="d-flex align-items-center">
										<div class="form-check">
											<input class="form-check-input" type="radio" name="option2_type" value="0" checked @if(old('option2_type'=='0')) checked @endif id="flexCheckDefault2">
											<label class="form-check-label font-w500" for="flexCheckDefault2">
												Text
											</label>
										</div>
										<div class="form-check ms-3">
											<input class="form-check-input" type="radio" name="option2_type" value="1" @if(old('option2_type'=='1')) checked @endif id="flexCheckDefault3">
											<label class="form-check-label font-w500" for="flexCheckDefault3">
												Image
											</label>
										</div>
									</div>
								</div>
								<div class="mb-3">
									<label for="exampleFormControlInput6" class="form-label text-primary">Text <span class="required">*</span></label>
									<textarea class="form-control @error('option2') is-invalid @enderror" rows="4" placeholder="Enter option 2 text" name="option2">{{old('option2')}}</textarea>

									@error('option2')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
								<div class="mb-3">
									<label class="form-label text-primary">Image <span class="required">*</span></label>
									<div class="avatar-upload">
										<div class="avatar-preview">
											<div id="imagePreview" style=""> 	
												<img src="{{asset('assets/images/no-img.svg')}}" id="output2" style="width:90px;height:90px">
											</div>
										</div>
										<div class="change-btn mt-2 mb-lg-0 mb-3">
											<input type="file" class="form-control d-none" id="imageUpload2" name="option2_image" onchange="showImagePreview2(event)" accept=".png, .jpg, .jpeg">
											<label for="imageUpload2" class="dlab-upload mb-0 btn btn-primary btn-sm">Choose File</label>
										</div>
									</div>
								</div>
							</div>

							<div class="col-xl-12">
								<hr>
							</div>
							<div class="col-xl-6 col-sm-6">
								<div class="mb-3">
									<label class="form-label text-primary">Option 3 <span class="required">*</span></label>
									<div class="d-flex align-items-center">
										<div class="form-check">
											<input class="form-check-input" type="radio" name="option3_type" value="0" checked @if(old('option3_type'=='0')) checked @endif id="flexCheckDefault4">
											<label class="form-check-label font-w500" for="flexCheckDefault4">
												Text
											</label>
										</div>
										<div class="form-check ms-3">
											<input class="form-check-input" type="radio" name="option3_type" value="1" @if(old('option3_type'=='1')) checked @endif id="flexCheckDefault5">
											<label class="form-check-label font-w500" for="flexCheckDefault5">
												Image
											</label>
										</div>
									</div>
								</div>
								<div class="mb-3">
									<label for="exampleFormControlInput6" class="form-label text-primary">Text <span class="required">*</span></label>
									<textarea class="form-control @error('option3') is-invalid @enderror" rows="4" placeholder="Enter option 3 text" name="option3">{{old('option3')}}</textarea>

									@error('option3')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
								<div class="mb-3">
									<label class="form-label text-primary">Image <span class="required">*</span></label>
									<div class="avatar-upload">
										<div class="avatar-preview">
											<div id="imagePreview" style=""> 	
												<img src="{{asset('assets/images/no-img.svg')}}" id="output3" style="width:90px;height:90px">
											</div>
										</div>
										<div class="change-btn mt-2 mb-lg-0 mb-3">
											<input type="file" class="form-control d-none" id="imageUpload3" name="option3_image" onchange="showImagePreview3(event)" accept=".png, .jpg, .jpeg">
											<label for="imageUpload3" class="dlab-upload mb-0 btn btn-primary btn-sm">Choose File</label>
										</div>
									</div>
								</div>
							</div>

							<div class="col-xl-6 col-sm-6">
								<div class="mb-3">
									<label class="form-label text-primary">Option 4 <span class="required">*</span></label>
									<div class="d-flex align-items-center">
										<div class="form-check">
											<input class="form-check-input" type="radio" name="option4_type" value="0" checked @if(old('option4_type'=='0')) checked @endif id="flexCheckDefault6">
											<label class="form-check-label font-w500" for="flexCheckDefault6">
												Text
											</label>
										</div>
										<div class="form-check ms-3">
											<input class="form-check-input" type="radio" name="option4_type" value="1" @if(old('option4_type'=='1')) checked @endif id="flexCheckDefault7">
											<label class="form-check-label font-w500" for="flexCheckDefault7">
												Image
											</label>
										</div>
									</div>
								</div>
								<div class="mb-3">
									<label for="exampleFormControlInput6" class="form-label text-primary">Text <span class="required">*</span></label>
									<textarea class="form-control @error('option4') is-invalid @enderror" rows="4" placeholder="Enter option 4 text" name="option4">{{old('option4')}}</textarea>

									@error('option4')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
								<div class="mb-3">
									<label class="form-label text-primary">Image <span class="required">*</span></label>
									<div class="avatar-upload">
										<div class="avatar-preview">
											<div id="imagePreview" style=""> 	
												<img src="{{asset('assets/images/no-img.svg')}}" id="output4" style="width:90px;height:90px">
											</div>
										</div>
										<div class="change-btn mt-2 mb-lg-0 mb-3">
											<input type="file" class="form-control d-none" id="imageUpload4" name="option4_image" onchange="showImagePreview4(event)" accept=".png, .jpg, .jpeg">
											<label for="imageUpload4" class="dlab-upload mb-0 btn btn-primary btn-sm">Choose File</label>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-12">
								<hr>
							</div>
							<div class="col-xl-6 col-sm-6">
								<div class="mb-3">
									<label class="form-label text-primary">Solution <span class="required">*</span></label>
								</div>
								<div class="mb-3">
									<label for="exampleFormControlInput6" class="form-label text-primary">Text <span class="required">*</span></label>
									<textarea class="form-control @error('solution_text') is-invalid @enderror" rows="4" placeholder="Enter solution text" name="solution_text">{{old('solution_text')}}</textarea>

									@error('solution_text')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
								<div class="mb-3">
									<label class="form-label text-primary">Image <span class="required">*</span></label>
									<div class="avatar-upload">
										<div class="avatar-preview">
											<div id="imagePreview" style=""> 	
												<img src="{{asset('assets/images/no-img.svg')}}" id="output5" style="width:90px;height:90px">
											</div>
										</div>
										<div class="change-btn mt-2 mb-lg-0 mb-3">
											<input type="file" class="form-control d-none" id="imageUpload5" name="solution_image" onchange="showImagePreview5(event)" accept=".png, .jpg, .jpeg">
											<label for="imageUpload5" class="dlab-upload mb-0 btn btn-primary btn-sm">Choose File</label>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-6 col-sm-6">
								<div class="mb-3">
									<label for="exampleFormControlInput3" class="form-label text-primary">Select Answer <span class="required">*</span></label>
									<select class="form-control @error('solution') is-invalid @enderror" name="solution">
										<option value="">Select</option>
										<option value="option1" @if(old('solution')=='option1') selected @endif>Option 1</option>
										<option value="option2" @if(old('solution')=='option2') selected @endif>Option 2</option>
										<option value="option3" @if(old('solution')=='option3') selected @endif>Option 3</option>
										<option value="option4" @if(old('solution')=='option4') selected @endif>Option 4</option>
										
									</select>
									@error('solution')
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
	function showImagePreview1(event) {
		var element = document.getElementById("imageUpload1");
		var output2 = document.getElementById('output1');
		output2.src = URL.createObjectURL(event.target.files[0]);
		output2.onload = function () {
			URL.revokeObjectURL(output2.src)
		}
	}

	function showImagePreview2(event) {
		var element = document.getElementById("imageUpload2");
		var output2 = document.getElementById('output2');
		output2.src = URL.createObjectURL(event.target.files[0]);
		output2.onload = function () {
			URL.revokeObjectURL(output2.src)
		}
	}
	function showImagePreview3(event) {
		var element = document.getElementById("imageUpload3");
		var output2 = document.getElementById('output3');
		output2.src = URL.createObjectURL(event.target.files[0]);
		output2.onload = function () {
			URL.revokeObjectURL(output2.src)
		}
	}
	function showImagePreview4(event) {
		var element = document.getElementById("imageUpload4");
		var output2 = document.getElementById('output4');
		output2.src = URL.createObjectURL(event.target.files[0]);
		output2.onload = function () {
			URL.revokeObjectURL(output2.src)
		}
	}

	function showImagePreview5(event) {
		var element = document.getElementById("imageUpload5");
		var output2 = document.getElementById('output5');
		output2.src = URL.createObjectURL(event.target.files[0]);
		output2.onload = function () {
			URL.revokeObjectURL(output2.src)
		}
	}
</script>
@endsection