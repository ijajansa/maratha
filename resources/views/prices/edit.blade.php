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
								<h4 class="nk-block-title">Update Price Details</h4>

							</div>
						</div>
						<div class="card card-bordered">
							<div class="card-inner">

								<form method="post" action="{{url('prices/edit')}}/{{$data->id}}">
									<input type="hidden" name="_token" value="{{csrf_token()}}">
									<div class="row g-4">
										<div class="col-xl-4 col-sm-4">
											<label for="search_input" class="form-label text-primary">Select Category <span class="required">*</span></label>
											<select class="form-control form-select" data-placeholder="Select Vehicle Category" name="category_id">
												<option value=""></option>
												@foreach($categories as $category)
												<option value="{{$category->id}}" @if($category->id == $data->category_id) selected @endif>{{$category->category_name}}</option>
												@endforeach
											</select>
											@error('category_id')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror
										</div>

										<div class="col-xl-4 col-sm-4">
											<label for="search_input1" class="form-label text-primary">No. of Days <span class="required">*</span></label>
											<!--<input type="number" min="1" max="365" class="form-control @error('days') is-invalid @enderror" id="search_input1" autocomplete="off" placeholder="Enter Number of Days" name="days" value="{{old('days',$data->days)}}">-->
											<select class="form-control form-select @error('days') is-invalid @enderror" id="search_input1" name="days" value="{{old('days')}}">
												<option value="0" @if(old('days')==0) selected @endif>Hourly</option>
											    <option value="1" @if(old('days',$data->days)==1) selected @endif>1 Day</option>
											    <option value="7" @if(old('days',$data->days)==7) selected @endif>7 Days</option>
											    <option value="15" @if(old('days',$data->days)==15) selected @endif>15 Days</option>
											    <option value="30" @if(old('days',$data->days)==30) selected @endif>30 Days</option>
											</select>
											@error('days')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror
										</div>

										<div class="col-xl-4 col-sm-4">
											<label for="search_input2" class="form-label text-primary">Amount <span class="required">*</span></label>
											<input type="number" min="0" class="form-control @error('amount') is-invalid @enderror" id="search_input2" autocomplete="off" placeholder="Enter Amount" name="amount" value="{{old('amount',$data->price)}}">
											@error('amount')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror
										</div>

										<div class="col-xl-4 col-sm-4">
											<label for="search_input3" class="form-label text-primary">Deposit Amount <span class="required">*</span></label>
											<input type="number" min="0" class="form-control @error('deposit') is-invalid @enderror" id="search_input3" autocomplete="off" placeholder="Enter Deposit Amount" name="deposit" value="{{old('deposit',$data->deposit)}}">
											@error('deposit')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror
										</div>

										<!-- <div class="col-xl-4 col-sm-4">
											<label for="search_input3" class="form-label text-primary">Hourly Charged Amount <span class="required">*</span></label>
											<input type="number" min="0" class="form-control @error('hourly_charge_amount') is-invalid @enderror" id="search_input3" autocomplete="off" placeholder="Enter Hourly Charged Amount" name="hourly_charge_amount" value="{{old('hourly_charge_amount',$data->hourly_charge_amount)}}">
											@error('hourly_charge_amount')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror
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


@endsection