<!--sidebar @s -->
<div class="nk-sidebar nk-sidebar-fixed is-dark " data-content="sidebarMenu">
    <div class="nk-sidebar-element nk-sidebar-head">
        <div class="nk-menu-trigger">
            <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
            <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
        </div>
        <div class="nk-sidebar-brand">
            <!-- <a href="#" class="logo-link nk-sidebar-logo">
                <img class="logo-light logo-img" src="{{config('app.baseURL')}}/images/logo.png" srcset="{{config('app.baseURL')}}/images/logo2x.png 2x" alt="logo">
                <img class="logo-dark logo-img" src="{{config('app.baseURL')}}/images/logo-dark.png" srcset="{{config('app.baseURL')}}/images/logo-dark2x.png 2x" alt="logo-dark">
            </a> -->
            <h4 class="nk-menu-text" style="color: #fff;">VEGO BIKE</h4>
        </div>
    </div><!-- .nk-sidebar-element -->
    <div class="nk-sidebar-element nk-sidebar-body">
        <div class="nk-sidebar-content">
            <div class="nk-sidebar-menu" data-simplebar>
                <ul class="nk-menu">
                    <li class="nk-menu-item">
                        <a href="{{url('home')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-dashboard-fill"></em></span>
                            <span class="nk-menu-text">Dashboard</span>
                        </a>
                    </li><!-- .nk-menu-item -->
                    <li class="nk-menu-item">
                        <a href="{{url('bookings/all')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-cart-fill"></em></span>
                            <span class="nk-menu-text">All Bookings</span>
                        </a>
                    </li><!-- .nk-menu-item -->
                    @if(Auth::user()->role_id == 1)
                    <li class="nk-menu-item">
                        <a href="{{url('stores/all')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-home"></em></span>
                            <span class="nk-menu-text">Store Master</span>
                        </a>
                    </li><!-- .nk-menu-item -->
                    @endif
                    <!--<li class="nk-menu-item">-->
                    <!--    <a href="{{url('locations/all')}}" class="nk-menu-link">-->
                    <!--        <span class="nk-menu-icon"><em class="icon ni ni-location"></em></span>-->
                    <!--        <span class="nk-menu-text">Location Master</span>-->
                    <!--    </a>-->
                    <!--</li>-->
                    @if(Auth::user()->role_id == 1)
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-layers-fill"></em></span>
                            <span class="nk-menu-text">Price Master</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{url('prices/all')}}" class="nk-menu-link"><span class="nk-menu-text">Pickup Tariff Plan</span></a>
                            </li>

                            <li class="nk-menu-item">
                                <a href="{{url('location-prices/all')}}" class="nk-menu-link"><span class="nk-menu-text">Delivery At Location Prices</span></a>
                            </li>
                        </ul><!-- .nk-menu-sub -->
                    </li><!-- .nk-menu-item -->
                    @endif
                    @if(Auth::user()->role_id == 1)
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-layers-fill"></em></span>
                            <span class="nk-menu-text">Master Records</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{url('categories/all')}}" class="nk-menu-link"><span class="nk-menu-text">All Categories</span></a>
                            </li>

                            <li class="nk-menu-item">
                                <a href="{{url('brands/all')}}" class="nk-menu-link"><span class="nk-menu-text">All Brands</span></a>
                            </li>

                            <li class="nk-menu-item">
                                <a href="{{url('models/all')}}" class="nk-menu-link"><span class="nk-menu-text">All Models</span></a>
                            </li>
                        </ul><!-- .nk-menu-sub -->
                    </li><!-- .nk-menu-item -->
                    @endif
                    @if(Auth::user()->role_id == 1)
                    <li class="nk-menu-item">
                        <a href="{{url('offers/all')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-tile-thumb"></em></span>
                            <span class="nk-menu-text">All Offers</span>
                        </a>
                    </li><!-- .nk-menu-item -->
                    @endif
                    <li class="nk-menu-item">
                        <a href="{{url('bikes/all')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-tile-thumb"></em></span>
                            <span class="nk-menu-text">All Bikes</span>
                        </a>
                    </li><!-- .nk-menu-item -->
                    @if(Auth::user()->role_id == 1)
                    <li class="nk-menu-item">
                        <a href="{{url('users/all')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
                            <span class="nk-menu-text">All Users</span>
                        </a>
                    </li><!-- .nk-menu-item -->
                    @endif
                    @if(Auth::user()->role_id == 1)
                    <li class="nk-menu-item">
                        <a href="{{url('customers/all')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
                            <span class="nk-menu-text">All Registered Customers</span>
                        </a>
                    </li><!-- .nk-menu-item -->
                    @endif
                    
                    @if(Auth::user()->role_id == 1)
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-file-fill"></em></span>
                            <span class="nk-menu-text">All Reports</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{url('booking-reports/all')}}" class="nk-menu-link"><span class="nk-menu-text">Booking Report</span></a>
                            </li>

                            <li class="nk-menu-item">
                                <a href="{{url('sales-reports/all')}}" class="nk-menu-link"><span class="nk-menu-text">Sales Report</span></a>
                            </li>

                            <li class="nk-menu-item">
                                <a href="{{url('gst-reports/all')}}" class="nk-menu-link"><span class="nk-menu-text">GST Report</span></a>
                            </li>
                            <!--<li class="nk-menu-item">-->
                            <!--    <a href="{{url('registration-reports/all')}}" class="nk-menu-link"><span class="nk-menu-text">Registration Report</span></a>-->
                            <!--</li>-->
                        </ul><!-- .nk-menu-sub -->
                    </li><!-- .nk-menu-item -->
                    @endif

                    <li class="nk-menu-item">
                        <a href="{{url('notifications')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-bell"></em></span>
                            <span class="nk-menu-text">Notifications</span>
                        </a>
                    </li><!-- .nk-menu-item -->

                </ul><!-- .nk-menu -->
            </div><!-- .nk-sidebar-menu -->
        </div><!-- .nk-sidebar-content -->
    </div><!-- .nk-sidebar-element -->
</div>
<!-- sidebar @e -->