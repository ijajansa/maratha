<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="../">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">

    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="{{asset('images/favicon.png')}}">
    <!-- Page Title  -->
    <title>Admin Dashboard</title>
    


    <!-- StyleSheets  -->
    <link rel="stylesheet" href="{{asset('assets/css/dashlite.css?ver=2.7.0')}}">
    <link id="skin-default" rel="stylesheet" href="{{asset('assets/css/theme.css?ver=2.7.0')}}">
    
    <link rel="stylesheet" type="text/css" href="https://code.jquery.com/jquery-3.5.1.js">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>

    <!-- Include Firebase JavaScript SDK -->


</head>

<body class="nk-body bg-lighter npc-general has-sidebar ">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            @include('layouts.sidebar')
            <!-- wrap @s -->
            <div class="nk-wrap ">
                @include('layouts.header')
                @yield('content')
                <audio id="myAudio" controls style="opacity:0;">
                  <source src="{{asset('assets/main-audio.wav')}}" type="audio/wav">
                </audio>
                
                <div class="modal fade" tabindex="-1" id="modalAlert">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <a href="javascript:void(0)" class="close" data-bs-dismiss="modal">
        <em class="icon ni ni-cross"></em>
      </a>
      <div class="modal-body modal-body-lg text-center">
        <div class="nk-modal">
          <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-check bg-success"></em>
          <h4 class="nk-modal-title">New Booking Request!</h4>
          <div class="nk-modal-text">
            <div class="caption-text" id="vehicleDetail"></div>
            </span>
          </div>
          <div class="nk-modal-action">
              
            <a  class="btn btn-lg btn-mw btn-primary" id="viewDetail">View Details</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
                
                @include('layouts.footer')
            </div>
            <!-- wrap @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <!-- JavaScript -->

    <script src="{{asset('assets/js/bundle.js?ver=2.7.0')}}"></script>
    <script src="{{asset('assets/js/scripts.js?ver=2.7.0')}}"></script>
    <script src="{{asset('assets/js/charts/gd-default.js?ver=2.7.0')}}"></script>
    <script src="{{asset('assets/js/apps/messages.js?ver=2.7.0')}}"></script>
    <script src="{{asset('assets/js/example-sweetalert.js?ver=3.2.1')}}"></script>
    <script src="{{asset('assets/js/charts/chart-crm.js?ver=3.2.1')}}"></script>
    <script type="text/javascript">
       @if(Session::has('message'))
       var type = "{{ Session::get('alert-type', 'info') }}";
       switch(type){
        case 'info':
        toastr.info("{{ Session::get('message') }}");
        break;

        case 'warning':
        toastr.warning("{{ Session::get('message') }}");
        break;

        case 'success':
        toastr.success("{{ Session::get('message') }}");
        break;

        case 'error':
        toastr.error("{{ Session::get('message') }}");
        break;
    }
    @endif
    
    $(".close").click(function(){
        $("#modalAlert").modal('hide');
    });
    
</script>
</body>

</html>