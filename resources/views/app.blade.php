<?php
  // header("Access-Control-Allow-Origin: *");
  // header("Access-Control-Allow-Methods: PUT, GET, POST");
  // header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

  $seg1 = Request::segment(1);
  $seg2 = Request::segment(2);
  $seg3 = Request::segment(3);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0 user-scalable=no" />
    @vite('resources/js/app.js')
    @vite('resources/css/app.css')
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="/assets/css/whether-icon.css">
	<!-- Font Awesome-->
    {{-- <link rel="stylesheet" type="text/css" href="/assets/css/fontawesome.css"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="/assets/css/icofont.css">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="/assets/css/themify.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="/assets/css/flag-icon.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="/assets/css/feather-icon.css">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="/assets/css/animate.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/chartist.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/date-picker.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/prism.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/vector-map.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/jkanban.css">
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    {{-- <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.css"> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
    <link id="color" rel="stylesheet" href="/assets/css/color-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="/assets/css/responsive.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/dropzone.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/date-picker.css">

    <link rel="stylesheet" type="text/css" href="/assets/css/daterange-picker.css">

    <link rel="stylesheet" type="text/css" href="/assets/css/select2.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
{{--    <link rel="stylesheet" type="text/css" href="../assets/css/photoswipe.css">--}}
    <!-- <link rel="stylesheet" type="text/css" href="/assets/css/timepicker.css"> -->

    <link rel="stylesheet" type="text/css" href="/assets/css/aksVideoPlayer.css">


    <link rel="stylesheet" type="text/css" href="/assets/css/summernote.css">
{{--    <link rel="stylesheet" type="text/css" href="/assets/css/sticky.css">--}}

    <link 
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />



	
	
	 <!-- latest jquery-->
	 <script src="/assets/js/jquery-3.5.1.min.js"></script>
    <!-- feather icon js-->
    <!-- <script src="https://dev2.buildovate.io/assets/js/icons/feather-icon/feather.min.js"></script> -->
    <!-- <script src="https://dev2.buildovate.io/assets/js/icons/feather-icon/feather-icon.js"></script> -->
    <!-- <script src="https://unpkg.com/feather-icons"></script> -->
    <!-- Sidebar jquery-->
    <script src="/assets/js/sidebar-menu.js"></script>
    <script src="/assets/js/config.js"></script>
    <!-- Bootstrap js-->
    <script src="/assets/js/bootstrap/popper.min.js"></script>
    <script src="/assets/js/bootstrap/bootstrap.min.js"></script>
    <!-- Plugins JS start-->
    <script src="/assets/js/chart/chartist/chartist.js"></script>
    <script src="/assets/js/chart/chartist/chartist-plugin-tooltip.js"></script>
    <script src="/assets/js/chart/knob/knob.min.js"></script>
    <script src="/assets/js/chart/knob/knob-chart.js"></script>
    <!-- <script src="/assets/js/chart/apex-chart/apex-chart.js"></script> -->
    <script src="/assets/js/chart/apex-chart/stock-prices.js"></script>
    <script src="/assets/js/prism/prism.min.js"></script>
    <script src="/assets/js/clipboard/clipboard.min.js"></script>
    <script src="/assets/js/counter/jquery.waypoints.min.js"></script>
    <script src="/assets/js/counter/jquery.counterup.min.js"></script>
    <script src="/assets/js/counter/counter-custom.js"></script>
    <script src="/assets/js/custom-card/custom-card.js"></script>
    <script src="/assets/js/notify/bootstrap-notify.min.js"></script>
    <script src="/assets/js/vector-map/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="/assets/js/vector-map/map/jquery-jvectormap-world-mill-en.js"></script>
    <script src="/assets/js/vector-map/map/jquery-jvectormap-us-aea-en.js"></script>
    <script src="/assets/js/vector-map/map/jquery-jvectormap-uk-mill-en.js"></script>
    <script src="/assets/js/vector-map/map/jquery-jvectormap-au-mill.js"></script>
    <script src="/assets/js/vector-map/map/jquery-jvectormap-chicago-mill-en.js"></script>
    <script src="/assets/js/vector-map/map/jquery-jvectormap-in-mill.js"></script>
    <script src="/assets/js/vector-map/map/jquery-jvectormap-asia-mill.js"></script>
    <script src="/assets/js/dashboard/default.js"></script>
    <script src="/assets/js/notify/index.js"></script>
    <script src="/assets/js/datepicker/date-picker/datepicker.js"></script>
    <script src="/assets/js/datepicker/date-picker/datepicker.en.js"></script>
    <script src="/assets/js/datepicker/date-picker/datepicker.custom.js"></script>
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="/assets/js/script.js"></script>
    <script src="/assets/js/theme-customizer/customizer.js"></script>
    
    <!-- login js-->
    <script src="/assets/js/jsgrid/jsgrid.min.js"></script>
    <script src="/assets/js/jsgrid/griddata.js"></script>
    <script src="/assets/js/jsgrid/jsgrid.js"></script>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
    <!-- <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v18.0&appId=<?php echo env('FBAPP_ID');?>" nonce="NoJ2AraB"></script> -->
    <!-- <script src="/assets/js/jkanban/jkanban.js"></script> -->
    <!-- <script src="/assets/js/jkanban/custom.js"></script> -->
    
    <!-- Plugin used-->
     <!-- Plugins JS start-->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBG0FHCOAnl0kcpfyzGP3JZ7ojqDd6EKGU&libraries=places"></script>
{{--    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyApZDF0wR5qwwrdkhhL_iyPRQ-uN0hDfYw&callback=initMap&libraries=places"></script>--}}
    <script src="/assets/js/dropzone/dropzone.js"></script>
<!-- {{--    <script src="/assets/js/dropzone/dropzone-script.js"></script>--}} -->
    <script src="/assets/js/tooltip-init.js"></script>

    <script src="/assets/js/datepicker/date-picker/datepicker.js"></script>
    <script src="/assets/js/datepicker/date-picker/datepicker.en.js"></script>
    <script src="/assets/js/datepicker/date-picker/datepicker.custom.js"></script>

    <script src="/assets/js/datepicker/daterange-picker/moment.min.js"></script>
    <script src="/assets/js/datepicker/daterange-picker/daterangepicker.js"></script>
    <script src="/assets/js/datepicker/daterange-picker/daterange-picker.custom.js"></script>

    <script src="/assets/js/select2/select2.full.min.js"></script>
    <script src="/assets/js/select2/select2-custom.js"></script>

    <script src="/assets/js/time-picker/jquery-clockpicker.min.js"></script>
    <script src="/assets/js/time-picker/highlight.min.js"></script>
    <script src="/assets/js/time-picker/clockpicker.js"></script>
{{--    <script src="/assets/js/sticky/sticky.js"></script>--}}
    <!-- <script src="/assets/js/editor/ckeditor/ckeditor.js"></script>
    <script src="/assets/js/editor/ckeditor/adapters/jquery.js"></script>
    <script src="/assets/js/editor/ckeditor/styles.js"></script>
    <script src="/assets/js/editor/ckeditor/ckeditor.custom.js"></script> -->

{{--    <script src="../assets/js/photoswipe/photoswipe.min.js"></script>--}}
{{--    <script src="../assets/js/photoswipe/photoswipe-ui-default.min.js"></script>--}}
{{--    <script src="../assets/js/photoswipe/photoswipe.js"></script>--}}

    <script src="/assets/js/aksvideoplayer/aksVideoPlayer.js"></script>

    <!-- Inside your index.html -->
    <script src="https://cdn.plaid.com/link/v2/stable/link-initialize.js"></script>

    <script src="/assets/js/jkanban/jkanban.js"></script>
    <script src="https://apis.google.com/js/api.js"></script>
    <script src="https://accounts.google.com/gsi/client" async defer></script>

    <!-- FLATICON -->
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.1.0/uicons-regular-straight/css/uicons-regular-straight.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.1.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>

    <!-- Plugins JS Ends-->
	<!--end::Javascript-->
    <meta name="csrf-token" content="{{ csrf_token() }}">
	@inertiaHead

  <style>
    .collapse {
        visibility: visible !important;
    }
    .default-according .card + .card{
      margin-top:0px !important;
    }
    .default-according .card .btn-link{
      font-size:12px !important;
    }
    #quickstartIcon:hover{
      color: #ffc107 !important;
    }
    .customizer-links .nav-link:hover:after{
      opacity:0 !important;
    }
    /* ================= */
    /* 
    32% +/- then it should be orange/red
    From 32%+/- to 65%+/- it should be olive green
    From 65%+/- to 99%+/- it should be baby blue
    When it reaches 100% it should close Quickstart  
    */
    .progress-bar {
      padding: 39px;
      font-size: 16px;
      font-weight: 600;
      color: #ff5349;
      /* color: #BAB86C !important; */
      /* color: #89cff0 !important; */
      
      display: inline-block;
      justify-content: center;
      align-items: center;

      width: 100px;
      height: 100px;
      border-radius: 50%;
      background: 
        /* radial-gradient(closest-side, white 79%, transparent 80% 100%), */
        /* conic-gradient(#24695c 60%, #e2c636 0); */
        /* red orange */
        /* conic-gradient(white 32%, #d2d2ce 0);  */
        /* olive green */
        /* conic-gradient(#BAB86C 65%, #d2d2ce 0); */
        /* baby blue */
        /* conic-gradient(#89cff0 85%, #d2d2ce 0);  */
        
    }

    .progress-bar::before {
      /* content: "32%"; */
      content:attr(data-content)
    }
    /* ================= */
  </style>

  </head>
  <body>


  <!-- @if($seg1=='inbox' && $seg2=='fb-messenger') -->
  <!-- FACEBOOK MESSENGER PLUGIN -->
    <!-- <div id="fb-root"></div> -->

    <!-- Your Chat Plugin code -->
    <!-- <div id="fb-customer-chat" class="fb-customerchat">
    </div>
    
    <script>
      var chatbox = document.getElementById('fb-customer-chat');
      chatbox.setAttribute("page_id", "147159478470782");
      chatbox.setAttribute("attribution", "biz_inbox");
    </script> -->

    <!-- Your SDK code -->
    <!-- <script>
      window.fbAsyncInit = function() {
        FB.init({
          xfbml            : true,
          version          : 'v18.0'
        });
      };

      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script> -->
  <!-- @endif -->
  <script>
    // import axios from 'axios';

    $('document').ready(function(){
      window.CSRF_TOKEN = '<?php echo  csrf_token(); ?>';

      // loadQuickStart(window.CSRF_TOKEN);
      // checkQuickstartProgress(window.CSRF_TOKEN); //load progress chart

    });

    /// This is called with the results from from FB.getLoginStatus().
    function statusChangeCallback(response) {
      console.log('statusChangeCallback');
      console.log(response);
      // The response object is returned with a status field that lets the
      // app know the current login status of the person.
      // Full docs on the response object can be found in the documentation
      // for FB.getLoginStatus().
      if (response.status === 'connected') {
        // Logged into your app and Facebook.
        saveAPI(response);
      } else {
        updateAPI();
        // The person is not logged into your app or we are unable to tell.
        // document.getElementById('status').innerHTML = 'Please log ' +
        //   'into this app.';
      }
    }

    // This function is called when someone finishes with the Login
    // Button.  See the onlogin handler attached to it in the sample
    // code below.
    function checkLoginState() {
      FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
      });
    }

    // Here we run a very simple test of the Graph API after login is
    // successful.  See statusChangeCallback() for when this call is made.
    function saveAPI(resp) {
      console.log('Welcome!  Fetching your information.... ');
      console.log('saveAPI resp',resp);
      // FB.api('/me', function(response) {
      //   console.log('Successful login for: ' + response.name);
      //   document.getElementById('status').innerHTML =
      //     'Thanks for logging in, ' + response.name + '!';
      // });

      $.post('/webhooks/save-facebook-token',
        {
          accessToken: resp.authResponse.accessToken,
          expiresIn: resp.authResponse.expiresIn,
          dataAccessExpiry: resp.authResponse.data_access_expiration_time,
          leadUserID: resp.authResponse.userID,
          signedRequest: resp.authResponse.signedRequest,
          // accessToken: 'teeest',
          // expiresIn: 0,
          // leadUserID: 1212,
          _token: '<?php echo csrf_token();?>'
        }, function (res) {
            console.log('res',res)
        }, 'json');

      // axios.post('/webhooks/facebook-leads-test', {
      //   accessToken: resp.authResponse.accessToken,
      //   expiresIn: resp.authResponse.expiresIn,
      //   leadUserID: resp.authResponse.userID
      // })
      // .then((res) => {
      //     if(res.data.success)
      //     {

      //         // Swal.fire({
      //         //     text: res.data.status,
      //         //     icon: "success",
      //         //     buttonsStyling: false,
      //         //     confirmButtonText: "Ok, got it!",
      //         //     customClass: {
      //         //         confirmButton: "btn btn-success"
      //         //     }
      //         // });

      //     }else{

      //         // Swal.fire({
      //         //     text: res.data.status,
      //         //     icon: "error",
      //         //     buttonsStyling: false,
      //         //     confirmButtonText: "Ok, got it!",
      //         //     customClass: {
      //         //         confirmButton: "btn btn-danger"
      //         //     }
      //         // });
              
      //     }

      //     // router.reload();
      
      // })
      // .catch((error) => {
      //     console.log(error.message);
      // });
    }

    //update API by regenerating the access_token
    function updateAPI() {
      console.log('regenerate access_token...');

      $.post('/webhooks/regen-facebook-token',
        {
          _token: '<?php echo csrf_token();?>'
        }, function (res) {
          if(res.data.status)
          {
            console.log('access_token successfully regenerated...');
          }
          console.log('res',res)
        }, 'json');
      
    }


    
	
    
	</script>
  <script>//TO DO: find more nice way.
    window.conditions = <?php echo json_encode(config('constant.conditions')) ?>;
    window.colors = <?php echo json_encode(config('constant.colors')) ?>;
    window.form_builder_fields = <?php echo json_encode(config('constant.form_builder_fields')) ?>;
    window.asset_link = <?php echo json_encode(config('constant.asset_link')) ?>; 
    window.plaid_access_token = {!! json_encode(session()->get('plaid_access_token')) !!};
  </script>

    @inertia

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html> 