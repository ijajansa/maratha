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
    <title>VeGo Dashboard</title>
    


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

    <script src="https://www.gstatic.com/firebasejs/7.18.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.18.0/firebase-messaging.js"></script>
    <script>
 
        const firebaseConfig = {
            apiKey: "AIzaSyDLNzkSKuszYtoe2U84Uvp7J27Hehg1pd4",
            authDomain: "vegobike-74d6e.firebaseapp.com",
            projectId: "vegobike-74d6e",
            storageBucket: "vegobike-74d6e.appspot.com",
            messagingSenderId: "659522969918",
            appId: "1:659522969918:web:825ffc8c93c7a2686d8c6f",
            measurementId: "G-61BLFF3764"
        };
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();
    
    
    messaging.onMessage(function (payload) {
        console.log(payload);
        const notificationOption={
            body:payload.notification.body,
            icon:payload.notification.icon
        };
            var x = document.getElementById("myAudio"); 
            var link = payload.notification.click_action;
            $("#modalAlert").modal('show');
            $("#vehicleDetail").text(payload.notification.body);
            $("#viewDetail").attr('href', link);
            x.play();
             var notification=new Notification(payload.notification.title,notificationOption);
             notification.onclick=function (ev) {
                ev.preventDefault();
                window.open(payload.notification.click_action,'_blank');
                notification.close();
             }
    });


    messaging.requestPermission()
  .then(() => {
    console.log('Notification permission granted.');
    // Retrieve the registration token
    messaging.getToken()
      .then((currentToken) => {
        if (currentToken) 
        {
            $.ajax({
                url:"{{url('update-token')}}",
                type:"GET",
                data:{token:currentToken},
                success:function(record)
                {
                    console.log("Token :", record);
                }
            });
          // Send this token to your server for later use
        } else {
          console.log('No registration token available.');
        }
      })
      .catch((error) => {
        console.error('Error getting registration token:', error);
      });
  })
  .catch((error) => {
    console.error('Unable to get permission to notify:', error);
  });


</script>
<script>
    if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('{{url("firebase-messaging-sw.js")}}')
      .then()
      .catch(err => console.error('Error', err));
  }
    </script>

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