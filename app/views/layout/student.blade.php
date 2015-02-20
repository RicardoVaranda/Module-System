<!Doctype html>
<html lang="en-US">
	<head>
	
		<!-- ==============================================
		Title and basic Metas
		=============================================== -->
        <meta charset="utf-8">
        <title>QuickMetro | Responsive Metro Style Template</title>
		<meta name="description" content="QuickMetro - Responsive Metro Style Template.">
		<meta name="author" content="ThemeArt">
		
		<!-- ==============================================
		Mobile Metas
		=============================================== -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<!-- ==============================================
		Fonts and CSS
		=============================================== -->
		{{ HTML::style('http://fonts.googleapis.com/css?family=Quicksand') }}
		{{ HTML::style('http://fonts.googleapis.com/css?family=Open+Sans') }}
		{{ HTML::style('css/font-awesome.min.css') }}
		{{ HTML::style('css/bootstrap.min.css') }}
		{{ HTML::style('css/style.css') }}
		
		<!-- ==============================================
		JS
		=============================================== -->
		{{ HTML::script('js/jquery-1.10.2.min.js') }}
		{{ HTML::script('js/modernizr.custom.97074.js') }}
		{{ HTML::script('http://maps.googleapis.com/maps/api/js?sensor=true') }}
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        
		<!--[if lt IE 9]>
			<script src="js/selectivizr.js"></script>
            <script src="js/respond.min.js"></script>
        <![endif]-->

        <!-- ==============================================
		Favicons
		=============================================== -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/icon/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/icon/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/icon/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="images/icon/apple-touch-icon-57-precomposed.png">
        <link rel="shortcut icon" href="images/icon/favicon.ico">
		
    </head>
    <body>
	
		<div class="wrapper">
		
		<div id="loading"></div>
	
        <nav class="navbar navbar-fixed-bottom navbar-default" role="navigation">
            <div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					</button>
					<a class="ascensorLink ascensorLink0 navbar-brand home-link" href="#">Home</a>
				</div>
		
				<div class="collapse navbar-collapse navbar-ex1-collapse">
					<ul class="nav navbar-nav pull-right">
						<li class="portfolio-menu"><a class="ascensorLink ascensorLink1" href="#">Electives</a></li>
						<li class="about-menu"><a class="ascensorLink ascensorLink2" href="#">Profile</a></li>
						<li class="service-menu"><a class="ascensorLink ascensorLink3" href="#">Timetable</a></li>
						<li class="signout-menu"><a class="ascensorLink" href="{{ URL::route('account-sign-out') }}">Sign out</a></li>
					</ul>
				</div>
            </div>
        </nav> <!-- /navbar -->
		
		<div id="ascensor">
		
			<section class="section home">
				<div class="center-box">
					<div class="container">
	
						<div class="tile tile-item tile-portfolio">
							<a class="ascensorLink ascensorLink1 tile-nav" href="#">
								<h5 class="h5">Electives</h5>
								<i class="fa fa-windows fa-4x"></i>
							</a>
						</div>
						<div class="tile tile-item tile-about">
							<a class="ascensorLink ascensorLink2 tile-nav" href="#">
								<h5 class="h5">Profile</h5>
								<i class="fa fa-heart fa-4x"></i>
							</a>
						</div>
						<div class="tile tile-item tile-service">
							<a class="ascensorLink ascensorLink3 tile-nav" href="#">
								<h5 class="h5">Timetable</h5>
								<i class="fa fa-calendar fa-4x"></i>
							</a>
						</div>
						<div class="tile tile-item tile-signout">
							<a class="ascensorLink tile-nav" href="{{ URL::route('account-sign-out') }}">
								<h5 class="h5">Sign Out</h5>
								<i class="fa fa-sign-out fa-4x"></i>
							</a>
						</div>
							
					</div>
				</div>
			</section> <!-- /home -->
			
			<section class="section portfolio">
				<div class="container">
					<h1 class="h1">Electives</h1>
					<div class="row">
						<div class="grid-controls">
							<ul>
									<li class="filter active" id="all" data-filter="all"><a href="#">All</a></li>
								@foreach (Faculty::all() as $fac)
									<li class="filter" id="{{ $fac->short() }}" data-filter="{{ $fac->short() }}"><a href="#">{{ $fac->facultyname }}</a></li>
								@endforeach
							</ul>

							@foreach (Faculty::all() as $fac)
									<select class="dep styled-select blue semi-square" id="{{ $fac->short() }}More" name="{{ $fac->short() }}Departments" >
										@foreach ($fac->departments as $dep)
											<option value="{{$dep->short()}}">{{ $dep->name() }}</option>
										@endforeach
									</select>
							@endforeach
							
						</div>
						<ul id="grid">
							@foreach(Modules::where('melective', 1)->get() as $mod)
								@include('layout.electivepreview', array('mod' => $mod))
							@endforeach
							<li class="gap"></li>
							<!-- "gap" elements fill in the gaps in justified grid -->
						</ul>
					</div>
				</div>
				<!-- Custom Javascript Filtering system - Ricardo -->

				<script type="text/javascript">
					$(document).ready(function(){
					    $("#buss").click(function(){
					        $("#bussMore").show();
					        $("#engMore").hide();
					    });
					    $("#all").click(function(){
					        $("#bussMore").hide();
					        $("#engMore").hide();
					    });
					    $("#eng").click(function(){
					        $("#bussMore").hide();
					        $("#engMore").show();
					    });
					    $("#music").click(function(){
					        $("#bussMore").hide();
					        $("#engMore").hide();
					    });
					    $("#art").click(function(){
					        $("#bussMore").hide();
					        $("#engMore").hide();
					    });
					    $("#maritime").click(function(){
					        $("#bussMore").hide();
					        $("#engMore").hide();
					    });
					});
				</script>

				<!-- End of Filtering system -->
			</section>
			<!-- /electives -->
			
			<section class="section about">
				<div class="container">
					<h1 class="h1">My Profile</h1>						
					<div class="row">
					
						<div class="col-sm-6 col-md-8 col-lg-8">
							<div class="profile">
								<h1>{{ Auth::user()->name }}</h1>
									<table>
										<tbody>
											<tr>
												<th><b>Student ID:</b></th>
												<td colspan="1">{{ Auth::user()->username }}</td>
											</tr>
											<tr>
												<th><b>Degree:</b></th>
												<td colspan="1">Ordinary Bachelor Degree</td>
											</tr>
											<tr>
												<th><b>Major:</b></th>
												<td colspan="1">Computing</td>
											</tr>
											<tr>
												<th><b>Program:</b></th>
												<td colspan="1">Bachelor of Science</td>
											</tr>
											<tr>
												<th><b>Class:</b></th>
												<td colspan="1">Third Year</td>
											</tr>
										</tbody>
									</table>
							</div>
						</div>
							
						<div class="col-sm-6 col-md-4 col-lg-4">
							<div class="profile" style="padding:40px 20px">
								<h4 class="h4">Settings</h4>
								<div class="skill-q" id="changePass">
									<p>Change Password</p>
									<a data-toggle="modal" class="submit btn btn-info btn-block" role="button" href="#contact">Change Password Now</a>
								</div>
								<div class="skill-q">
									<p>Change Secret Question?</p>
									<a data-toggle="modal" class="submit btn btn-info btn-block" role="button" href="#sQuestion">Change Question Now</a>
								</div>	
							</div>
						</div>
					</div>
					@extends('account.password')
					<div class="row">
						<hr class="metro-hr">
						<h2 class="h2 lead">My Modules</h2>
						<div class="col-sm-6 col-md-4">
							<div class="feature-box">
								<div class="feature-icon"><i class="fa fa-twitter"></i></div>
								<div class="feature-text">
									<h3>Object Oriented Analysis & Design</h3>
									<small style="float:right"><u>Manditory</u></small>
									<p>Mary Davin</p>
									<button type="button" class="pull-right btn btn-primary"><i class="fa fa-arrow-right"></i>check timetable</button>
									</br>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-4">
							<div class="feature-box">
								<div class="feature-icon"><i class="fa fa-twitter"></i></div>
								<div class="feature-text">
									<h3>Internet Network & Services</h3>
									<small style="float:right"><u>Manditory</u></small>
									<p>Mary Davin</p>
									<button type="button" class="pull-right btn btn-primary"><i class="fa fa-arrow-right"></i>check timetable</button>
									</br>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-4">
							<div class="feature-box">
								<div class="feature-icon"><i class="fa fa-twitter"></i></div>
								<div class="feature-text">
									<h3>Server-Side Web Development</h3>
									<small style="float:right"><u>Manditory</u></small>
									<p>Mary Davin</p>
									<button type="button" class="pull-right btn btn-primary"><i class="fa fa-arrow-right"></i>check timetable</button>
									</br>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-4">
							<div class="feature-box">
								<div class="feature-icon"><i class="fa fa-twitter"></i></div>
								<div class="feature-text">
									<h3>Object Oriented Analysis & Design</h3>
									<small style="float:right"><u>Manditory</u></small>
									<p>Mary Davin</p>
									<button type="button" class="pull-right btn btn-primary"><i class="fa fa-arrow-right"></i>check timetable</button>
									</br>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-4">
							<div class="feature-box">
								<div class="feature-icon"><i class="fa fa-twitter"></i></div>
								<div class="feature-text">
									<h3>Internet Network & Services</h3>
									<small style="float:right"><u>Manditory</u></small>
									<p>Mary Davin</p>
									<button type="button" class="pull-right btn btn-primary"><i class="fa fa-arrow-right"></i>check timetable</button>
									</br>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-4">
							<div class="feature-box">
								<div class="feature-icon"><i class="fa fa-twitter"></i></div>
								<div class="feature-text">
									<h3>Server-Side Web Development</h3>
									<small style="float:right"><u>Manditory</u></small>
									<p>Mary Davin</p>
									<button type="button" class="pull-right btn btn-primary"><i class="fa fa-arrow-right"></i>check timetable</button>
									</br>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-4">
							<div class="feature-box">
								<div class="feature-icon"><i class="fa fa-twitter"></i></div>
								<div class="feature-text">
									<h3>Object Oriented Analysis & Design</h3>
									<small style="float:right"><u>Manditory</u></small>
									<p>Mary Davin</p>
									<button type="button" class="pull-right btn btn-primary"><i class="fa fa-arrow-right"></i>check timetable</button>
									</br>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-4">
							<div class="feature-box">
								<div class="feature-icon"><i class="fa fa-twitter"></i></div>
								<div class="feature-text">
									<h3>Internet Network & Services</h3>
									<small style="float:right"><u>Manditory</u></small>
									<p>Mary Davin</p>
									<button type="button" class="pull-right btn btn-primary"><i class="fa fa-arrow-right"></i>check timetable</button>
									</br>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-4">
							<div class="feature-box">
								<div class="feature-icon"><i class="fa fa-twitter"></i></div>
								<div class="feature-text">
									<h3>Server-Side Web Development</h3>
									<small style="float:right"><u>Manditory</u></small>
									<p>Mary Davin</p>
									<button type="button" class="pull-right btn btn-primary"><i class="fa fa-arrow-right"></i>check timetable</button>
									</br>
								</div>
							</div>
						</div>
						<hr class="metro-hr">
					</div>
						
				</div>
            </section> 
			<!-- profile -->
			
			<section class="section service">  
				<div class="container">	
					<h1 class="h1">Timetable</h1>
					
					<div class="row">
						<hr class="metro-hr">
						<div class="col-sm-9">
							<p>Many good things to come...</p>
						</div>
						<hr class="metro-hr">
					</div>

					
				</div>
			</section> 
			<!-- /timetable -->	
		</div> 
		<!-- /ascensor -->
		
		</div> <!-- /wrapper -->
		
		<!-- ==============================================
		JS
		=============================================== -->
		{{ HTML::script('js/jquery.ascensor.js') }}
		{{ HTML::script('js/bootstrap.min.js') }}
		{{ HTML::script('js/jquery.mixitup.min.js') }}
		{{ HTML::script('js/jquery.hoverdir.js') }}
		{{ HTML::script('js/jquery.placeholder.min.js') }}
		{{ HTML::script('js/main.js') }}

    </body>
</html>