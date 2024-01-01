@extends('layouts.app')
@section('content')
<style type="text/css">
	
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
								<h4 class=" nk-block-title">Update Offer Details</h4>

							</div>
						</div>
						<div class="card card-bordered">
							<div class="card-inner">

								<form method="post" enctype="multipart/form-data" action="{{url('offers/edit')}}/{{$record->id}}">
									<input type="hidden" name="_token" value="{{csrf_token()}}">
									<div class="row g-4">
										<div class="col-lg-8">
											<div class="row">
												<div class="col-lg-6">
													<div class="form-group">
														<label for="demo-text-input1" class="form-label text-primary">Offer Name</label>
														<div class="form-control-wrap">
															<input type="text" id="demo-text-input1" name="offer_name" class="form-control form-control-md @error('offer_name') is-invalid @enderror" placeholder="Enter Offer Name" value="{{old('offer_name',$record->offer_name)}}" />
															@error('offer_name')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
															@enderror
														</div>
													</div>
												</div>

												<div class="col-lg-6">
													<div class="form-group">
														<label for="demo-text-input1" class="form-label text-primary">Coupon Code</label>
														<div class="form-control-wrap">
															<input type="text" id="demo-text-input1" name="offer_code" class="form-control form-control-md @error('offer_code') is-invalid @enderror" placeholder="Enter Coupon Code" value="{{old('offer_code',$record->offer_code)}}" />
															@error('offer_code')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
															@enderror
														</div>
													</div>
												</div>
												<div class="col-lg-6 mt-2">
													<div class="form-group">
														<label for="demo-text-input15" class="form-label text-primary">Discount Type</label>
														<div class="form-control-wrap">

															<select class="form-control form-control-md @error('discount_type') is-invalid @enderror" name="discount_type">
																<option value="">Select Discount Type</option>
																<option value="amount" @if(old('discount_type',$record->discount_type)=='amount') selected @endif>Amount</option>
																<option value="percentage" @if(old('discount_type',$record->discount_type)=='percentage') selected @endif>Percentage</option>
															</select>
															@error('discount_type')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
															@enderror
														</div>
													</div>
												</div>

												<div class="col-lg-6 mt-2">
													<div class="form-group">
														<label for="demo-text-input14" class="form-label text-primary">Discount Value</label>
														<div class="form-control-wrap">
															<input type="text" id="demo-text-input14" name="discount_value" class="form-control form-control-md @error('discount_value') is-invalid @enderror" placeholder="Enter Discount Value" value="{{old('discount_value',$record->discount_value)}}" />
															@error('discount_value')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
															@enderror
														</div>
													</div>
												</div>
												<div class="col-lg-6 mt-2">
													<div class="form-group">
														<label for="demo-text-input15" class="form-label text-primary">Applies To</label>
														<div class="form-control-wrap">

															<select class="form-control form-control-md @error('applies_to') is-invalid @enderror" name="applies_to">
																<option value="">Select</option>
																<option value="first" @if(old('applies_to',$record->applies_to)=='first') selected @endif>First Order</option>
																<option value="entire" @if(old('applies_to',$record->applies_to)=='entire') selected @endif>Entire Order</option>
															</select>
															@error('applies_to')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
															@enderror
														</div>
													</div>
												</div>


												<div class="col-lg-6 mt-2">
													<div class="form-group">
														<label for="demo-text-input16" class="form-label text-primary">Minimum Ride Amount</label>
														<div class="form-control-wrap">
															<input type="text" id="demo-text-input16" name="minimum_amount" class="form-control form-control-md @error('minimum_amount') is-invalid @enderror" placeholder="Enter Minimum Ride Amount" value="{{old('minimum_amount',$record->minimum_amount)}}" />
															@error('minimum_amount')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
															@enderror
														</div>
													</div>
												</div>

												<div class="col-lg-6 mt-2">
													<div class="form-group">
														<label for="demo-text-input18" class="form-label text-primary">Offer Start Date & Time</label>
														<div class="form-control-wrap">
															<input type="datetime-local" min="1" id="demo-text-input18" name="start_date" class="form-control form-control-md @error('start_date') is-invalid @enderror" placeholder="" value="{{old('start_date',$record->start_date)}}" />
															@error('start_date')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
															@enderror
														</div>
													</div>
												</div>
												<div class="col-lg-6 mt-2">
													<div class="form-group">
														<label for="demo-text-input18" class="form-label text-primary">Offer End Date & Time</label>
														<div class="form-control-wrap">
															<input type="datetime-local" min="1" id="demo-text-input18" name="end_date" class="form-control form-control-md @error('end_date') is-invalid @enderror" placeholder="" value="{{old('end_date',$record->end_date)}}" />
															@error('end_date')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
															@enderror
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-lg-4">
											<div class="row">
												<div class="col-lg-12">
													<div class="form-group">
														<label for="demo-text-input17" class="form-label text-primary">Customer Eligibility</label>
														<div class="form-control-wrap">
															<input type="radio" value="everyone" checked name="eligibility" @if(old('eligibility',$record->eligibility)=='everyone') checked @endif id="check12">&nbsp;&nbsp;<label for="check12">Everyone</label><br>
															<input type="radio" value="specific_customer" @if(old('eligibility',$record->eligibility)=='specific_customer') checked @endif name="eligibility" id="check21">&nbsp;&nbsp;<label for="check21">Specific customer</label>

															<select class="form-control form-control-md form-select @error('customer_ids') is-invalid @enderror" name="customer_ids[]" id="showMultiselect" multiple data-search="on" style="display: none;">
																<option value="">Select Customers</option>
																@foreach($customers as $customer)
																<option value={{$customer->id}}   @if($customer->is_present==1) selected @endif>{{$customer->name}}</option>
																	@endforeach
																</select>
																@error('customer_ids')
																<span class="invalid-feedback" role="alert">
																	<strong>{{ $message }}</strong>
																</span>
																@enderror
															</div>
														</div>
													</div>
													<div class="col-lg-12 mt-2">
														<div class="form-group">
															<label for="demo-text-input17" class="form-label text-primary">Usage Limits</label>
															<div class="form-control-wrap">
																<input type="checkbox" name="limit1" id="check1" value="1" @if(old('limit1',$record->limit1)==1) checked @endif>&nbsp;&nbsp;<label for="check1">Limit number of times this discount can be used.</label>
																<input type="number" min="1" id="demo-text-input17" name="usage_limit" style="width: 100px;" class="form-control form-control-md @error('usage_limit') is-invalid @enderror" value="{{old('usage_limit',$record->usage_limit)}}" />
																@error('usage_limit')
																<span class="invalid-feedback" role="alert">
																	<strong>{{ $message }}</strong>
																</span>
																@enderror
																<div style="margin-top: 20px;">
																	<input type="checkbox" name="limit2" id="check2" value="0" @if(old('limit2',$record->limit2)==0) checked @endif>&nbsp;&nbsp;<label for="check2">Limit to only one use per customer.</label>
																</div>
															</div>
														</div>
													</div>
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
		$(document).ready(function(){
			$(".select2-container").css("display", "none !important");
		});
		$('input[type=radio][name=eligibility]').change(function() {
			if (this.value == 'everyone') {
				$(".select2-container").css("display", "none !important");
			}
			else if (this.value == 'specific_customer') {
				$(".select2-container").css("display", "block !important");
			}
		});
	</script>
	@endsection