<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>Team 666</title>
      <!-- site icon -->
      <!-- <link rel="icon" href="images/fevicon.png" type="image/png" /> -->
      <!-- bootstrap css -->
	  
	  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
      <!-- site css -->
	  <link rel="stylesheet" href="{{ asset('style.css') }}">
      <!-- responsive css -->
	  <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
      <!-- color css -->
      <!-- select bootstrap -->
	  <link rel="stylesheet" href="{{ asset('css/bootstrap-select.css') }}">
      <!-- scrollbar css -->
	  <link rel="stylesheet" href="{{ asset('css/perfect-scrollbar.css') }}">
      <!-- custom css -->
	  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
      <link rel="stylesheet" href="{{ asset('css/datatable/dataTables.bootstrap4.min.css') }}">
      <link rel="stylesheet" href="{{ asset('css/datatable/jquery.dataTables.min.css') }}">
   </head>
   <body class="dashboard dashboard_1">
      <div class="full_container">
         <div class="inner_container">
            <!-- Sidebar  -->
            <nav id="sidebar">
               <div class="sidebar_blog_1">
                  <div class="sidebar-header">
                     <div class="logo_section">
                        <a href="index.html"><img class="logo_icon img-responsive" src="{{ asset('images/logo/logo_icon.png') }}" alt="#" /></a>
                     </div>
                  </div>
                  <div class="sidebar_user_info">
                     <div class="icon_setting"></div>
                     <div class="user_profle_side">
                        <div class="user_img"><img class="img-responsive" src="{{ asset('images/666.jpeg') }}" alt="#" /></div>
                        <div class="user_info">
                           <h6>{{Auth::user()->name??''}}</h6>
                           <p><span class="online_animation"></span> Online</p>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="sidebar_blog_2">
                  <!-- <h4>General</h4> -->
                  <ul class="list-unstyled components">
                     <li><a href="{{ route('home') }}"><i class="fa fa-dashboard yellow_color"></i> <span>Dashboard</span></a></li>
                     <li><a href="{{ route('transaction.index') }}"><i class="fa fa-table purple_color2"></i> <span>Transactions</span></a></li>
                     <li><a href="{{ route('user.index') }}"><i class="fa fa-user blue2_color"></i> <span>User</span></a></li>
                     <li><a data-toggle="modal" data-target="#changePassModal" style="cursor:pointer"><i class="fa fa-key"></i> <span>Change Password</span></a></li>
                     <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> <span>{{ __('Logout') }}</span></a></li>
                     
                     <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                     </form>
                     
                  </ul>
               </div>
            </nav>
            <!-- end sidebar -->
            <!-- right content -->
            <div id="content">
               <!-- topbar -->
               <div class="topbar">
                  <nav class="navbar navbar-expand-lg navbar-light">
                     <div class="full">
                        <button type="button" id="sidebarCollapse" class="sidebar_toggle"><i class="fa fa-bars"></i></button>
                        <div class="logo_section">
                           <!-- <a href="index.html"><img class="img-responsive" src="images/logo/logo.png" alt="#" /></a> -->
                        </div>
                        <div class="right_topbar">
                           <div class="icon_info">
                              <!-- <ul>
                                 <li><a href="#"><i class="fa fa-bell-o"></i><span class="badge">2</span></a></li>
                                 <li><a href="#"><i class="fa fa-question-circle"></i></a></li>
                                 <li><a href="#"><i class="fa fa-envelope-o"></i><span class="badge">3</span></a></li>
                              </ul> -->
                              <!-- <ul class="user_profile_dd">
                                 <li>
                                    <a class="dropdown-toggle" data-toggle="dropdown"><img class="img-responsive rounded-circle" src="{{ asset('images/layout_img/user_img.jpg') }}" alt="#" /><span class="name_user">{{Auth::user()->role??''}}</span></a>
                                    <div class="dropdown-menu">
										<a class="dropdown-item" href="emailservices.html">
											<i class="dropdown-icon icon icon-speech"></i> Inbox
										</a>
										<a class="dropdown-item" href="editprofile.html">
											<i class="dropdown-icon  icon icon-settings"></i> Account Settings
										</a>

                                    </div>
                                 </li>
                              </ul> -->
                           </div>
                        </div>
                     </div>
                  </nav>
               </div>
               <!-- end topbar -->
               <!-- dashboard inner -->
               <div class="midde_cont">
                  <div class="container-fluid">
                     
					@include('layouts.flash-message')
					@yield('content')
                     <!-- graph -->
                     
                  </div>
			<div id="changePassModal" class="modal fade">
				<div class="modal-dialog modal-md" role="document">
					<div class="modal-content ">
						<div class="modal-header pd-x-20">
							<h4 class="modal-title font-weight-bold">Change Password</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form enctype="multipart/form-data" method="post" action="{{ route('user.changePassword') }}">
              			@csrf
						<div class="modal-body pd-20">
							<div class="form-group">
								<label for="change-password"><b>Current password</b></label>
								<input type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" autocomplete="current_password" placeholder="Current Password..">
									@error('current_password')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
								<div class="form-group">
								<input type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="password" placeholder="New Password..">
									@error('password')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
								<div class="form-group">
								<input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" autocomplete="password_confirmation" placeholder="Confirm Password..">
									@error('password_confirmation')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
						</div><!-- modal-body -->
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary">Save changes</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
						</form>
					</div>
				</div><!-- modal-dialog -->
			</div>
                  <!-- footer -->
                  
               </div>
               <!-- end dashboard inner -->
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
      <!-- owl carousel -->
        <script src="{{ asset('js/owl.carousel.js') }}"></script>
      <!-- chart js -->
        <script src="{{ asset('js/Chart.min.js') }}"></script>
        <script src="{{ asset('js/Chart.bundle.min.js') }}"></script>
        <script src="{{ asset('js/utils.js') }}"></script>
        <script src="{{ asset('js/analyser.js') }}"></script>
      <!-- nice scrollbar -->
        <script src="{{ asset('js/perfect-scrollbar.min.js') }}"></script>
      <script>
         var ps = new PerfectScrollbar('#sidebar');
      </script>
        <script src="{{ asset('css/datatable/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('css/datatable/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('js/datatable.js') }}"></script>
      <!-- custom js -->
        <script src="{{ asset('js/custom.js') }}"></script>
        <!-- <script src="{{ asset('js/chart_custom_style1.js') }}"></script> -->
   </body>
</html>