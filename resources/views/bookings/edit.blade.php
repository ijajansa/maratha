@extends('layouts.app')
@section('content')

<div class="nk-content " style="margin-top: 40px;">
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
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="row">
									<div class="col-lg-12">
									   
										<div class="card card-bordered">
											<div class="card-inner">
											    <div class="nk-block-head">
									                <div class="row">
									                    <div class="col-lg-6">
									                        <div class="nk-block-head-content">
												            <h4 class=" nk-block-title">View Booking Details</h4>
											                </div>
									                    </div>
									                    @if($data->booking_status == 6)
									                        <div class="col-lg-6">
									                            <p align="right"><a href="{{url('bookings/invoice-details')}}/{{$data->id}}"><button class="btn btn-primary"><i class="icon ni ni-file"></i>&nbsp;View Invoice</button></a></p>
									                        </div>
									                    @endif
									                </div>
										        </div> 
												<form method="post" action="{{url('bookings/status')}}/{{$data->id}}">
													<input type="hidden" name="_token" value="{{csrf_token()}}">
													<div class="row g-4">
													<div class="col-xl-12 col-sm-12">
															<label for="search_input" class="form-label text-primary">Vehicle Image</label><br>
															<img src="{{url('storage/app')}}/{{$data->bike_details->bike_image}}" style="width:150px;height:150px">
															</div>
														<div class="col-xl-4 col-sm-4">
															<label for="search_input" class="form-label text-primary">Booking ID <span class="required">*</span></label>
															<input type="text" class="form-control" id="search_input" autocomplete="off" placeholder="Enter Booking ID" readonly value="{{$data->booking_id}}">
														</div>

														<div class="col-xl-4 col-sm-4">
															<label for="search_input1" class="form-label text-primary">Start Date <span class="required">*</span></label>
															<input type="text" class="form-control" id="search_input1" autocomplete="off" placeholder="Enter Start Date" readonly value="{{date('d-m-Y h:i A',strtotime($data->start_date))}}">
														</div>

														<div class="col-xl-4 col-sm-4">
															<label for="search_input2" class="form-label text-primary">End Date <span class="required">*</span></label>
															<input type="text" class="form-control" id="search_input2" autocomplete="off" placeholder="Enter End Date" readonly value="{{date('d-m-Y h:i A',strtotime($data->end_date))}}">
														</div>

														<div class="col-xl-4 col-sm-4">
															<label for="search_input3" class="form-label text-primary">Vehicle Number <span class="required">*</span></label>
															<input type="text" class="form-control" id="search_input3" autocomplete="off" placeholder="Enter Vehicle Number" readonly value="{{$data->bike_details->registration_number}}">
														</div>

														<div class="col-xl-4 col-sm-4">
															<label for="search_input4" class="form-label text-primary">Customer Name <span class="required">*</span></label>
															<input type="text" class="form-control" id="search_input4" autocomplete="off" placeholder="Enter Customer Name" readonly value="{{$data->user_details->name}}">
														</div>

														<div class="col-xl-4 col-sm-4">
															<label for="search_input5" class="form-label text-primary">Customer Contact Number <span class="required">*</span></label>
															<input type="text" class="form-control" id="search_input5" autocomplete="off" placeholder="Enter Customer Contact Number" readonly value="{{$data->user_details->contact_number}}">
														</div>

														<div class="col-xl-8 col-sm-8">
															<label for="search_input6" class="form-label text-primary">Address <span class="required">*</span></label>
															<input type="text" class="form-control" id="search_input6" autocomplete="off" placeholder="Enter Address" readonly value="{{$data->address}}">
														</div>

														<div class="col-xl-4 col-sm-4">
															<label for="search_input7" class="form-label text-primary">Address Type <span class="required">*</span></label>
															<input type="text" class="form-control" id="search_input7" autocomplete="off" placeholder="Enter Address Type" readonly value="{{$data->address_type}}">
														</div>

														@if($data->delivery_type!=null)
														<div class="col-xl-4 col-sm-4">
															<label for="search_input17" class="form-label text-primary">Delivery Type <span class="required">*</span></label>
															<input type="text" class="form-control" id="search_input17" autocomplete="off" placeholder="Enter Delivery Type" readonly value="{{$data->delivery_type}}">
														</div>
														@endif

												<!-- <div class="col-xl-6 col-sm-6">
													<label for="search_input8" class="form-label text-primary">Vehicle Pickup Location <span class="required">*</span></label>
													<input type="text" class="form-control" id="search_input8" autocomplete="off" placeholder="Enter Pickup Location" readonly value="{{$data->pickup_location_id ?? null}}">
												</div>
												<div class="col-xl-6 col-sm-6">
													<label for="search_input8" class="form-label text-primary">Vehicle Drop Location <span class="required">*</span></label>
													<input type="text" class="form-control" id="search_input8" autocomplete="off" placeholder="Enter Drop Location" readonly value="{{$data->drop_location_id ?? null}}">
												</div> -->

												<div class="col-xl-12">
													<hr>
												</div>
                                                
                                                <div class="col-xl-4 col-sm-4">
													<label for="search_input23" class="form-label text-primary">Ride Fee <span class="required">*</span></label>
													<input type="text" class="form-control" id="search_input23" autocomplete="off" placeholder="Ride Fee" readonly value="{{$data->charges ?? 0}}">
												</div>

												<!--<div class="col-xl-4 col-sm-4">-->
												<!--	<label for="search_input10" class="form-label text-primary">Total Hours <span class="required">*</span></label>-->
												<!--	<input type="text" class="form-control" id="search_input10" autocomplete="off" placeholder="Enter Total Hours" readonly value="{{$data->total_hours ?? 0}}">-->
												<!--</div>-->

												<!--<div class="col-xl-4 col-sm-4">-->
												<!--	<label for="search_input11" class="form-label text-primary">Additional Hours <span class="required">*</span></label>-->
												<!--	<input type="text" class="form-control" id="search_input11" autocomplete="off" placeholder="Enter Additional Hours" readonly value="{{$data->additional_hours ?? 0}}">-->
												<!--</div>-->

												<!-- <div class="col-xl-4 col-sm-4">
													<label for="search_input12" class="form-label text-primary">Additional Charges <span class="required">*</span></label>
													<input type="text" class="form-control" id="search_input12" autocomplete="off" placeholder="Enter Additional Charges" readonly value="{{$data->additional_charges ?? 0}}">
												</div> -->

												<!--<div class="col-xl-4 col-sm-4">
													<label for="search_input12" class="form-label text-primary">Taxable Amount <span class="required">*</span></label>
													<input type="text" class="form-control" id="search_input12" autocomplete="off" placeholder="Enter Total Charges" readonly value="{{$data->total_charges ?? 0}}">
												</div>-->
												@if($data->address_type !='Self Pickup')
												<div class="col-xl-4 col-sm-4">
													<label for="search_input12" class="form-label text-primary">Delivery Charges <span class="required">*</span></label>
													<input type="text" class="form-control" id="search_input12" autocomplete="off" placeholder="Enter Total Charges" readonly value="{{$data->delivery_charges ?? 0}}">
												</div>
												@endif
												@if($data->booking_status == 6)
												<div class="col-xl-4 col-sm-4">
													<label for="search_input13" class="form-label text-primary">Additional Charges</label>
													<input type="number" class="form-control" id="search_input13" value="{{$data->additional_charges}}" readonly autocomplete="off" placeholder="Enter Additional Charges" >
												</div>
												@endif
												<div class="col-xl-4 col-sm-4">
													<label for="search_input12" class="form-label text-primary">GST 5% <span class="required">*</span></label>
													<input type="text" class="form-control" id="search_input12" autocomplete="off" placeholder="Enter Total Charges" readonly value="{{$data->gst ?? 0}}">
												</div>
													<div class="col-xl-4 col-sm-4">
													<label for="search_input9" class="form-label text-primary">Refundable Deposit Amount <span class="required">*</span></label>
													<input type="text" class="form-control" id="search_input9" autocomplete="off" placeholder="Refundable Deposit Amount" readonly value="{{$data->advance_amount ?? 0}}">
												</div>
												<!--<div class="col-xl-4 col-sm-4">-->
												<!--	<label for="search_input12" class="form-label text-primary">SGST 2.5% <span class="required">*</span></label>-->
												<!--	<input type="text" class="form-control" id="search_input12" autocomplete="off" placeholder="Enter Total Charges" readonly value="{{$data->gst/2 ?? 0}}">-->
												<!--</div>-->
												
												<div class="col-xl-4 col-sm-4">
													<label for="search_input12" class="form-label text-primary">Total Ride Fair <span class="required">*</span></label>
													<input type="text" class="form-control" id="search_input12" autocomplete="off" placeholder="Enter Total Charges" readonly value="{{$data->charges + $data->delivery_charges + $data->gst + $data->additional_charges}}">
												</div>


												<div class="col-xl-12">
													<hr>
												</div>
												@if($data->coupon_id!=null)
												<div class="col-xl-4 col-sm-4">
													<label for="search_input113" class="form-label text-primary">Applied Coupon Code</label>
													<input type="text" class="form-control" id="search_input113" value="{{$data->coupon_code}}" readonly>
												</div>
												<div class="col-xl-4 col-sm-4">
													<label for="search_input133" class="form-label text-primary">Discount Amount</label>
													<input type="text" class="form-control" id="search_input133" value="{{$data->coupon_amount}}" readonly>
												</div>
												<div class="col-xl-12">
													<hr>
												</div>
												@endif
												<div class="col-xl-4 col-sm-4">
													<label for="search_input13" class="form-label text-primary">Additional Charges</label>
													<input type="number" class="form-control" id="search_input13" @if($data->booking_status == 6) value="{{$data->additional_charges}}" readonly @endif autocomplete="off" placeholder="Enter Additional Charges" name="additional_charges">
												</div>

												<div class="col-xl-8 col-sm-8">
													<label for="search_input14" class="form-label text-primary">Additional Charges Details</label>
													<input type="text" class="form-control" id="search_input14" @if($data->booking_status == 6) value="{{$data->additional_charges_details}}" readonly @endif autocomplete="off" placeholder="Enter Additional Charges Details" name="additional_charges_details">
												</div>
												<div class="col-xl-12 col-sm-12">
													<label for="search_input14" class="form-label text-primary">Booking Status <span class="required">*</span></label>
													<select class="form-control form-select" data-placeholder="Select Booking Status"  @if($data->booking_status == 6) readonly disabled @endif name="booking_status">
														@foreach($statuses as $status)
														<option value="{{$status->id}}" @if($data->booking_status == $status->id) selected @endif>{{$status->name}}</option>
														@endforeach
													</select>
												</div>
												<div class="col-xl-12">
													<div class="form-group">
														<button type="submit" class="btn btn-lg btn-primary" @if($data->booking_status == 6) readonly disabled @endif>Update Booking Details</button>
													</div>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>

							<div class="col-lg-12 mt-3">
								<div class="card card-bordered">
									<div class="card-inner">
									<div class="nk-block-head">
										<div class="nk-block-head-content">
											<h4 class=" nk-block-title">View Customer Documents</h4>
										</div>
									</div>
										<div class="row g-4">
										
											<div class="col-xl-4 col-sm-4">
												<label class="form-label text-primary">Adhaar Front Image</label><br>
												@if($documents->adhaar_front_image!=null)
												<img src="{{url('storage/app')}}/{{$documents->adhaar_front_image}}" width="80%" style="display:block;margin-bottom:4px;height: 150px">
												@endif
												@if($documents->is_adhaar_front_verified == 2)
												<span class="text-success"><i class="icon ni ni-check-circle"></i> Verified Document</span>
												@elseif($documents->is_adhaar_front_verified == 0)
												<span class="text-warning"><i class="icon ni ni-alert-circle"></i> Document not uploaded</span>
												@elseif($documents->is_adhaar_front_verified == 3)
												<span class="text-danger"><i class="icon ni ni-cross-circle"></i> Rejected document</span>
												@else
												<span class="text-warning"><i class="icon ni ni-alert-circle"></i> Verification pending</span>
													<div class="tb-odr-btns d-md-inline"><a href='{{url("customers")}}/verify-adhaar-front/{{$documents->id}}' class="btn btn-sm btn-outline-success">Verify Document</a></div>
												@endif
											</div>
											<div class="col-xl-4 col-sm-4">
												<label class="form-label text-primary">Adhaar Back Image</label><br>
												@if($documents->adhaar_back_image!=null)
												<img src="{{url('storage/app')}}/{{$documents->adhaar_back_image}}" width="80%" style="display:block;margin-bottom:4px;height: 150px">
												@endif
												@if($documents->is_adhaar_back_verified == 2)
												<span class="text-success"><i class="icon ni ni-check-circle"></i> Verified Document</span>
												@elseif($documents->is_adhaar_back_verified == 0)
												<span class="text-warning"><i class="icon ni ni-alert-circle"></i> Document not uploaded</span>
												@elseif($documents->is_adhaar_back_verified == 3)
												<span class="text-danger"><i class="icon ni ni-cross-circle"></i> Rejected document</span>
												@else
												<span class="text-warning"><i class="icon ni ni-alert-circle"></i> Verification pending</span>
												<div class="tb-odr-btns d-md-inline"><a href='{{url("customers")}}/verify-adhaar-back/{{$documents->id}}' class="btn btn-sm btn-outline-success">Verify Document</a></div>
												@endif
											</div>
											<div class="col-xl-4 col-sm-4">
												<label class="form-label text-primary">Driving License Image</label><br>
												@if($documents->driving_license_image!=null)
												<img src="{{url('storage/app')}}/{{$documents->driving_license_image}}" width="80%" style="display:block;margin-bottom:4px;height: 150px">
												@endif
												@if($documents->is_license_verified == 2)
												<span class="text-success"><i class="icon ni ni-check-circle"></i> Verified Document</span>
												@elseif($documents->is_license_verified == 0)
												<span class="text-warning"><i class="icon ni ni-alert-circle"></i> Document not uploaded</span>
												@elseif($documents->is_license_verified == 3)
												<span class="text-danger"><i class="icon ni ni-cross-circle"></i> Rejected document</span>
												@else
												<span class="text-warning"><i class="icon ni ni-alert-circle"></i> Verification pending</span>
												<div class="tb-odr-btns d-md-inline"><a href='{{url("customers")}}/verify-driving-license/{{$documents->id}}' class="btn btn-sm btn-outline-success">Verify Document</a></div>
												@endif
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--<div class="col-lg-4">-->
					<!--	<div class="row">-->
					<!--		@if(count($images))-->
					<!--		<div class="col-lg-12">-->
					<!--			<div class="nk-block-head">-->
					<!--				<div class="nk-block-head-content">-->
					<!--					<h4 class="title nk-block-title">Before Start Trip Photos</h4>-->
					<!--				</div>-->
					<!--			</div>-->
					<!--			<div class="card card-bordered">-->
					<!--				<div class="card-inner">-->
					<!--					<div style="display: flex;width: 100%;flex-wrap: wrap;">-->
					<!--						@foreach($images as $image)-->
					<!--						@if($image->type==1)-->
					<!--						<div style="width: 33.33%">-->
					<!--							<a href="{{url('storage/app')}}/{{$image->images}}" target="_blank">-->
					<!--								<img src="{{url('storage/app')}}/{{$image->images}}" style="width: 100%">-->
					<!--							</a>-->
					<!--						</div>-->
					<!--						@endif-->
					<!--						@endforeach-->
					<!--					</div>-->
					<!--				</div>-->
					<!--			</div>-->
					<!--		</div>-->
					<!--		@endif-->
					<!--		@if(count($images))-->

					<!--		<div class="col-lg-12">-->
					<!--			<div class="nk-block-head" style="margin-top: 20px">-->
					<!--				<div class="nk-block-head-content">-->
					<!--					<h4 class="title nk-block-title">Before End Trip Photos</h4>-->
					<!--				</div>-->
					<!--			</div>-->
					<!--			<div class="card card-bordered">-->
					<!--				<div class="card-inner">-->
					<!--					<div style="display: flex;width: 100%;flex-wrap: wrap;">-->
					<!--						@foreach($images as $image)-->
					<!--						@if($image->type==2)-->
					<!--						<div style="width: 33.33%">-->
					<!--							<a href="{{url('storage/app')}}/{{$image->images}}" target="_blank">-->
					<!--								<img src="{{url('storage/app')}}/{{$image->images}}" style="width: 100%">-->
					<!--							</a>-->
					<!--						</div>-->
					<!--						@endif-->
					<!--						@endforeach-->
					<!--					</div>-->
					<!--				</div>-->
					<!--			</div>-->
					<!--		</div>-->
					<!--		@endif-->

					<!--	</div>-->

					<!--</div>-->
				</div>
			</div><!-- .nk-block -->
		</div><!-- .components-preview -->
	</div>
</div>
</div>
</div>


@endsection