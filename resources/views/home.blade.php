<style>
    .white-btn{
        background:#fff !important;
    }
</style>
@extends('layouts.app')
@section('content')
<div class="nk-content ">
            <div class="container-fluid">
              <div class="nk-content-inner">
                <div class="nk-content-body">
                  <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                      <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">VeGo Dashboard</h3>
                        <div class="nk-block-des text-soft">
                          <p>Welcome to VeGo Dashboard Panel</p>
                        </div>
                      </div>
                     
                    </div>
                  </div>
                  <div class="nk-block">
                    <div class="row g-gs">
                        <div class="col-md-3">
                            <div class="card text-white bg-primary">
                            <div class="card-inner text-right">
                                <h4 class="card-title">{{number_format($bookings['today'])}}</h4>
                                <p class="card-text">Today's Bookings</p>
                                <a href="{{url('bookings/all')}}?date={{date('Y-m-d')}}"><button type="button" class="btn white-btn">View All</button></a>
                            </div>
                        </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="card text-white bg-warning">
                            <div class="card-inner text-right">
                                <h4 class="card-title">{{number_format($bookings['ongoing'])}}</h4>
                                <p class="card-text">Ongoing Bookings</p>
                                <a href="{{url('bookings/all')}}?status=2"><button type="button" class="btn white-btn">View All</button></a>
                            </div>
                        </div>
                        </div>
                        
                        
                        <div class="col-md-3">
                            <div class="card text-white bg-danger">
                            <div class="card-inner text-right">
                                <h4 class="card-title">{{number_format($bookings['cancelled'])}}</h4>
                                <p class="card-text">Cancelled Bookings</p>
                                <a href="{{url('bookings/all')}}?status=8"><button type="button" class="btn white-btn">View All</button></a>
                            </div>
                        </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="card text-white bg-success">
                            <div class="card-inner text-right">
                                <h4 class="card-title">{{number_format($bookings['completed'])}}</h4>
                                <p class="card-text">Completed Bookings</p>
                                <a href="{{url('bookings/all')}}?status=6"><button type="button" class="btn white-btn">View All</button></a>
                            </div>
                        </div>
                        </div>
                        @if(Auth::user()->role_id ==1)
                        <div class="col-md-3">
                            <div class="card text-white bg-info">
                            <div class="card-inner text-right">
                                <h4 class="card-title">{{number_format($users['all'])}}</h4>
                                <p class="card-text">Total Users</p>
                                <a href="{{url('customers/all')}}"><button type="button" class="btn white-btn">View All</button></a>
                            </div>
                        </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="card text-white bg-success">
                            <div class="card-inner text-right">
                                <h4 class="card-title">{{number_format($users['verified'])}}</h4>
                                <p class="card-text">Total Verified Users</p>
                                <a href="{{url('customers/all')}}?status=1"><button type="button" class="btn white-btn">View All</button></a>
                            </div>
                        </div>
                        </div>
                        
                    <div class="col-md-3">
                            <div class="card text-white bg-warning">
                            <div class="card-inner text-right">
                                <h4 class="card-title">{{number_format($users['unverified'])}}</h4>
                                <p class="card-text">Total Unverified Users</p>
                                <a href="{{url('customers/all')}}?status=2"><button type="button" class="btn white-btn">View All</button></a>
                            </div>
                        </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="card text-white bg-danger">
                            <div class="card-inner text-right">
                                <h4 class="card-title">{{number_format($users['zero'])}}</h4>
                                <p class="card-text">Users With 0 Bookings</p>
                                <button type="button" class="btn white-btn">View All</button>
                            </div>
                        </div>
                        </div>
                        @endif
                     
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
@endsection