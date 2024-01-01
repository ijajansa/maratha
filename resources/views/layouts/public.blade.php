<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="../../../">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Admin dashboard for managing vehicles and user registrations details">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="{{asset('images/favicon.png')}}">
    <!-- Page Title  -->
    <title>VeGO | Panel</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="{{asset('assets/css/dashlite.css?ver=2.7.0')}}">
    <link id="skin-default" rel="stylesheet" href="{{asset('assets/css/theme.css?ver=2.7.0')}}">
    <style type="text/css">
        /*        .card-bordered {*/
            /*    border: 1px solid #dbdfea;*/
            /*}*/

            @media (min-width: 768px)
            {
                .card-inner-lg {
                    padding: 25px 2.5rem;
                }    
            }

            .nk-content{
                background:linear-gradient(0deg, rgb(48 71 113), rgb(56 48 113 / 21%)), url("{{asset('assets/pictures/login_background.jpg')}}");
      
                background-size: cover;
                height: 100%;
            }
        </style>
    </head>

    <body class="nk-body bg-white npc-general pg-auth">
        <div class="nk-app-root">
            <!-- main @s -->
            <div class="nk-main ">
                <!-- wrap @s -->
                <div class="nk-wrap nk-wrap-nosidebar">
                    <!-- content @s -->
                    <div class="nk-content ">
                        <div class="nk-block nk-block-middle nk-auth-body  wide-xs" style="box-shadow:1px 1px 10px rgba(0,0,0,0.1);background: #fff;border-radius: 20px;">
                            <div class="brand-logo text-center">
                                <a href="#" class="logo-link">
                                <!-- <img class="logo-light logo-img logo-img-lg" src="{{asset('images/logo.png')}}" srcset="{{asset('images/logo2x.png')}} 2x" alt="logo">
                                    <img class="logo-dark logo-img logo-img-lg" src="{{asset('images/logo-dark.png')}}" srcset="{{asset('images/logo-dark2x.png')}} 2x" alt="logo-dark"> -->
                                    <div style="display: inline-block;background: #304771;width: 120px;height: 120px;border-radius: 50%;">
                                        <img src="{{url('assets/pictures/app_logo.png')}}" style="
                                        width: 90px;
                                        height: 90px;
                                        padding: 5px;
                                        margin-top: 9px;
                                        border-radius: 30% 50% 0 50%;
                                        ">
                                    </div>
                                    <!-- <h3>VeGo Bike</h3> -->
                                </a>
                            </div>
                            @yield('content')

                        </div>
                   <!--  <div class="nk-footer nk-auth-footer-full">
                        <div class="container wide-lg">
                            <div class="row g-3">                                
                                <div class="col-lg-6">
                                    <div class="nk-block-content text-center text-lg-left">
                                        <p class="text-soft"> &copy; 2023 <a href="https://bpointer.com/" target="_blank"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
                <!-- wrap @e -->
            </div>
            <!-- content @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <!-- JavaScript -->
    <script src="{{asset('assets/js/bundle.js?ver=2.7.0')}}"></script>
    <script src="{{asset('assets/js/scripts.js?ver=2.7.0')}}"></script>

    </html>