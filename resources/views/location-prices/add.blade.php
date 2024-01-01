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
								<h4 class="nk-block-title">Add Price</h4>

							</div>
						</div>
						<div class="card card-bordered">
							<div class="card-inner">

								<form method="post" action="{{url('location-prices/add')}}">
									<input type="hidden" name="_token" value="{{csrf_token()}}">
									<div class="row g-4">
										<div class="col-xl-4 col-sm-4">
											<label for="search_input" class="form-label text-primary">Select Kilometers <span class="required">*</span></label>
											<select class="form-control form-select @error('km') is-invalid @enderror" data-placeholder="Select Kilometers" name="km">
												<option value=""></option>
												@for($i=1;$i<=50;$i++)
												<option value="{{$i}}" @if(old('km')==$i) selected @endif>{{$i}}</option>
												@endfor
											</select>
											@error('km')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror
										</div>

							

										<div class="col-xl-4 col-sm-4">
											<label for="search_input2" class="form-label text-primary">Amount <span class="required">*</span></label>
											<input type="number" min="0" class="form-control @error('amount') is-invalid @enderror" id="search_input2" autocomplete="off" placeholder="Enter Amount" name="amount" value="{{old('amount')}}">
											@error('amount')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror
										</div>

										
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


@endsection