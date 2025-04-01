<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <!-- Meta data -->
		<meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->

    <!-- Title -->
	<title>SUPER RECHARGE BACKOFFICE</title>
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
        <link rel="stylesheet" href="{{ asset('css/bootstrap-select.css') }}">
        <link rel="stylesheet" href="{{ asset('css/perfect-scrollbar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">



</head>
	<body class="inner_page login">
		<div class="full_container">
         <div class="container">
            <div class="center verticle_center full_height">
               <div class="login_section">
                  <div class="logo_login">
                     <div class="center">
						<h3 class="card-title" style="color:white">SUPER RECHARGE BACKOFFICE</h3>
                     </div>
                  </div>
                  <div class="login_form">
					@include('layouts.flash-message')
					<form method="POST" action="{{ route('login') }}">
						@csrf
                        <fieldset>
                           <div class="field">
                              <label class="label_field">Username</label>
                              <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" placeholder="Enter username" required autocomplete="username" autofocus>
                           </div>
                           <div class="field">
                              <label class="label_field">Password</label>
								<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                           </div>
                           <div class="field margin_0">
							  
						   <label class="label_field hidden">hidden label</label>
							  <button type="submit" class="main_bt">
                                            {{ __('Login') }}
                                        </button>
                           </div>
                        </fieldset>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>

		

		


      <!-- jQuery -->
	  <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/popper.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
      <!-- wow animation -->
        <script src="{{ asset('js/animate.js') }}"></script>
      <!-- select country -->
        <script src="{{ asset('js/bootstrap-select.js') }}"></script>
        <script src="{{ asset('js/perfect-scrollbar.min.js') }}"></script>
      <script>
         var ps = new PerfectScrollbar('#sidebar');
      </script>
        <script src="{{ asset('js/custom.js') }}"></script>
        <!-- <script src="{{ asset('js/chart_custom_style1.js') }}"></script> -->
	</body>
</html>