<!--sidebar @s -->
<div class="nk-sidebar nk-sidebar-fixed is-dark " data-content="sidebarMenu">
    <div class="nk-sidebar-element nk-sidebar-head">
        <div class="nk-menu-trigger">
            <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
            <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
        </div>
        <div class="nk-sidebar-brand">
            {{-- <a href="#" class="logo-link nk-sidebar-logo">
                <img class="logo-light logo-img" src="{{asset('assets/logo.png')}}" alt="logo">
                <img class="logo-dark logo-img" src="{{asset('assets/logo.png')}}" alt="logo-dark">
            </a> --}}
            <h4 class="nk-menu-text" style="color: #fff;">मराठा समाज पॅनेल </h4>
        </div>
    </div><!-- .nk-sidebar-element -->
    <div class="nk-sidebar-element nk-sidebar-body">
        <div class="nk-sidebar-content">
            <div class="nk-sidebar-menu" data-simplebar>
                <ul class="nk-menu">
                    <li class="nk-menu-item">
                        <a href="{{url('home')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-dashboard-fill"></em></span>
                            <span class="nk-menu-text">मुखपृष्ठ</span>
                        </a>
                    </li><!-- .nk-menu-item -->
                    
                    <li class="nk-menu-item">
                        <a href="{{url('users/all')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
                            <span class="nk-menu-text">सभासदे</span>
                        </a>
                    </li><!-- .nk-menu-item -->
                  
                    {{-- <li class="nk-menu-item">
                        <a href="{{url('family-users/all')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
                            <span class="nk-menu-text">All Sabhasad Family</span>
                        </a>
                    </li> --}}
                  
                </ul><!-- .nk-menu -->
            </div><!-- .nk-sidebar-menu -->
        </div><!-- .nk-sidebar-content -->
    </div><!-- .nk-sidebar-element -->
</div>
<!-- sidebar @e -->