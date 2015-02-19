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
						<li class="service-menu"><a class="ascensorLink ascensorLink3" href="#">Settings</a></li>
						<li class="team-menu"><a class="ascensorLink ascensorLink4" href="#">Team</a></li>
						<li class="client-menu"><a class="ascensorLink ascensorLink5" href="#">Clients</a></li>
						<li class="blog-menu"><a class="ascensorLink ascensorLink6" href="#">Blog</a></li>
						<li class="contact-menu"><a class="ascensorLink ascensorLink7" href="#">Contact</a></li>
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
								<h5 class="h5">My info</h5>
								<i class="fa fa-sitemap fa-4x"></i>
							</a>
						</div>
						<div class="tile tile-item tile-team">
							<a class="ascensorLink ascensorLink4 tile-nav" href="#">
								<h5 class="h5">Team</h5>
								<i class="fa fa-group fa-4x"></i>
							</a>
						</div>
						<div class="tile tile-item tile-client">
							<a class="ascensorLink ascensorLink5 tile-nav" href="#">
								<h5 class="h5">Clients</h5>
								<i class="fa fa-smile-o fa-4x"></i>
							</a>
						</div>
						<div class="tile tile-item tile-blog">
							<a class="ascensorLink ascensorLink6 tile-nav" href="#">
								<h5 class="h5">Blog</h5>
								<i class="fa fa-edit fa-4x"></i>
							</a>
						</div>
						<div class="tile tile-item tile-contact">
							<a class="ascensorLink ascensorLink7 tile-nav" href="#">
								<h5 class="h5">Contact</h5>
								<i class="fa fa-envelope fa-4x"></i>
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
			<!-- /portfolio -->
			
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
					<div class="modal fade" id="contact" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog">
							<div  class="contact-box">
		                    	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		                        <form name="contactform" id="contactform" action="php/contactform.php" method="post">
		                            <fieldset>
		                                <h4 class="h4">Change Your Password</h4>
		                                <div class="form-group">
		                                    <i class="fa fa-unlock"></i>
		                                    <input type="password" name="pass" id="pass" class="form-control" placeholder="Old Password (required)" required>
		                                </div>
		                                <div class="form-group">
		                                    <i class="fa fa-key"></i>
		                                    <input type="password" name="newPass" id="npassword" class="form-control" placeholder="New Password (required)" required>
		                                </div>
		                                <div class="form-group">
		                                    <i class="fa fa-key"></i>
		                            		<input type="password" name="passAgain" id="passagain" class="form-control" placeholder="Password Again (required)" required>
		         		                </div>
		                                <div class="form-group">
		                                    <i class="fa fa-arrow-right"></i>
		                                    <button  type="submit" id="submit" class="btn btn-info btn-block">Change Password</button>
		                                </div>
		                            </fieldset>
		                        </form>
		                        <div id="state-message"></div>
							</div>
						</div>
					</div>
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
			<!-- /about -->
			
			<section class="section service">  
				<div class="container">	
					<h1 class="h1">My Info</h1>
					
					<div class="row">
						<hr class="metro-hr">
						<div class="col-sm-9">
							<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
							Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
							when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
						</div>
						<div class="col-sm-3">
							<ul class="check-our-work">
								<li class="portfolio"><a class="ascensorLink ascensorLink1" href="#">Check our Portfolio</a></li>
							</ul>
						</div>
						<hr class="metro-hr">
					</div>

					<div class="row">
						<div class="col-sm-6 col-md-4">
							<div class="brick">
							<div class="service-img"> <i class="fa fa-cloud-upload fa-5x"></i> </div>
								<h6 class="service-title">Save your time for pleasure!</h6>
								<h4 class="h4">Save On Cloud</h4>
								<p class="service-desc">Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
								Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
								when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
							</div>
						</div>
						<div class="col-sm-6 col-md-4">
							<div class="brick">
								<div class="service-img"> <i class="fa fa-print fa-5x"></i> </div>
								<h6 class="service-title">Create your individual website look!</h6>
								<h4 class="h4">Print Your Document</h4>
								<p class="service-desc">Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
								Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
								when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
							</div>
						</div>
						<div class="col-sm-6 col-md-4">
							<div class="brick">
								<div class="service-img"> <i class="fa fa-magic fa-5x"></i> </div>
								<h6 class="service-title">Lorem Ipsum is simply dummy text!</h6>
								<h4 class="h4">Magic is in Your Hand</h4>
								<p class="service-desc">Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
								Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
								when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
							</div>
						</div>
					</div>
					
					<div class="row">
						<hr class="metro-hr">
						<h2 class="h2 lead">My Modules</h2>
						<div class="col-sm-6 col-md-4">
							<div class="feature-box">
								<div class="feature-icon"><i class="fa fa-twitter"></i></div>
								<div class="feature-text">
									<h3>Twitter</h3>
									<p>Justo a urna dolor et lorem vulputate.</p>
								</div>
							</div>
							<div class="feature-box">
								<div class="feature-icon"><i class="fa fa-magic"></i></div>
								<div class="feature-text">
									<h3>FontAwesome Icons</h3>
									<p>Justo a urna dolor et lorem vulputate.</p>
								</div>
							</div>
							<div class="feature-box">
								<div class="feature-icon"><i class="fa fa-font"></i></div>
								<div class="feature-text">
									<h3>Google Fonts</h3>
									<p>Class aptent taciti sociosqu torquent.</p>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-4">
							<div class="feature-box">
								<div class="feature-icon"><i class="fa fa-move"></i></div>
								<div class="feature-text">
									<h3>Bootstrap</h3>
									<p>Justo a urna dolor et lorem vulputate.</p>
								</div>
							</div>
							<div class="feature-box">
								<div class="feature-icon"><i class="fa fa-laptop"></i></div>
								<div class="feature-text">
									<h3>HTML 5 / CSS 3</h3>
									<p>Duis rutrum faucibus massa sagittis.</p>
								</div>
							</div>
							<div class="feature-box">
								<div class="feature-icon"><i class="fa fa-font"></i></div>
								<div class="feature-text">
									<h3>Modern</h3>
									<p>Justo a urna dolor et lorem vulputate.</p>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-4">
							<div class="feature-box">
								<div class="feature-icon"><i class="fa fa-twitter"></i></div>
								<div class="feature-text">
									<h3>CrossBrowser</h3>
									<p>Justo a urna dolor et lorem vulputate.</p>
								</div>
							</div>
							<div class="feature-box">
								<div class="feature-icon"><i class="fa fa-magic"></i></div>
								<div class="feature-text">
									<h3>FontAwesome Icons</h3>
									<p>Justo a urna dolor et lorem vulputate.</p>
								</div>
							</div>
							<div class="feature-box">
								<div class="feature-icon"><i class="fa fa-font"></i></div>
								<div class="feature-text">
									<h3>Google Fonts</h3>
									<p>Class aptent taciti sociosqu torquent.</p>
								</div>
							</div>
						</div>
						<hr class="metro-hr">
					</div>
					
				</div>
			</section> 
			<!-- /service -->
			
            <section class="section team">
					<div class="container">
						<h1 class="h1">Creative Team</h1>
						<div class="row">
							<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
								<div class="team-member">
									<img src="images/team/team-member.jpg" alt="team_member">
									<h3 class="h3 lead">Tom Smith</h3>
									<h5 class="h5">Founder</h5>
									<ul class="member-social">
										<li><a href="https://twitter.com/" target="_blank"><i class="fa fa-twitter fa-2x"></i></a></li>
										<li><a href="http://www.facebook.com" target="_blank"><i class="fa fa-facebook fa-2x"></i></a></li>
										<li><a href="http://www.dribbble.com" target="_blank"><i class="fa fa-dribbble fa-2x"></i></a></li>
									</ul>
								</div>
							</div>
							<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
								<div class="team-member">
									<img src="images/team/team-member.jpg" alt="team_member">
									<h3 class="h3 lead">Tom Smith</h3>
									<h5 class="h5">Founder</h5>
									<ul class="member-social">
										<li><a href="https://twitter.com/" target="_blank"><i class="fa fa-twitter fa-2x"></i></a></li>
										<li><a href="http://www.facebook.com" target="_blank"><i class="fa fa-facebook fa-2x"></i></a></li>
										<li><a href="http://www.dribbble.com" target="_blank"><i class="fa fa-dribbble fa-2x"></i></a></li>
									</ul>
								</div>
							</div>
							<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
								<div class="team-member">
									<img src="images/team/team-member.jpg" alt="team_member">
									<h3 class="h3 lead">Sam Peterson</h3>
									<h5 class="h5">Developer</h5>
									<ul class="member-social">
										<li><a href="https://twitter.com/" target="_blank"><i class="fa fa-twitter fa-2x"></i></a></li>
										<li><a href="http://www.facebook.com" target="_blank"><i class="fa fa-facebook fa-2x"></i></a></li>
										<li><a href="http://www.dribbble.com" target="_blank"><i class="fa fa-dribbble fa-2x"></i></a></li>
									</ul>
								</div>
							</div>
							<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
								<div class="team-member">
									<img src="images/team/team-member.jpg" alt="team_member">
									<h3 class="h3 lead">John Smith</h3>
									<h5 class="h5">Developer</h5>
									<ul class="member-social">
										<li><a href="https://twitter.com/" target="_blank"><i class="fa fa-twitter fa-2x"></i></a></li>
										<li><a href="http://www.facebook.com" target="_blank"><i class="fa fa-facebook fa-2x"></i></a></li>
										<li><a href="http://www.dribbble.com" target="_blank"><i class="fa fa-dribbble fa-2x"></i></a></li>
									</ul>
								</div>
							</div>
							<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
								<div class="team-member">
									<img src="images/team/team-member.jpg" alt="team_member">
									<h3 class="h3 lead">Natasha Smith</h3>
									<h5 class="h5">Project Manager</h5>
									<ul class="member-social">
										<li><a href="https://twitter.com/" target="_blank"><i class="fa fa-twitter fa-2x"></i></a></li>
										<li><a href="http://www.facebook.com" target="_blank"><i class="fa fa-facebook fa-2x"></i></a></li>
										<li><a href="http://www.dribbble.com" target="_blank"><i class="fa fa-dribbble fa-2x"></i></a></li>
									</ul>
								</div>
							</div>
							<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
								<div class="team-member">
									<img src="images/team/team-member.jpg" alt="team_member">
									<h3 class="h3 lead">Jessica Doe</h3>
									<h5 class="h5">Designer</h5>
									<ul class="member-social">
										<li><a href="https://twitter.com/" target="_blank"><i class="fa fa-twitter fa-2x"></i></a></li>
										<li><a href="http://www.facebook.com" target="_blank"><i class="fa fa-facebook fa-2x"></i></a></li>
										<li><a href="http://www.dribbble.com" target="_blank"><i class="fa fa-dribbble fa-2x"></i></a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
            </section> 
			<!-- /team -->
			
			<section class="section client">
				<div class="center-box">
				<div class="container">
					<h1 class="h1">Happy Clients</h1>
					<h3 class="h3 lead">What they say about our Services.</h3>
					<div class="row">
						<div class="col-sm-6 col-sm-push-6 col-md-6 col-md-push-6 col-lg-6 col-lg-push-6">
							<div class="photos">
								<div class="author"></div>
								<ul>
									<li class="quote-1 active"><a href="#"><img class="img-responsive" src="images/client/client.jpg" alt="Tom Smith - Founder"></a></li>
									<li class="quote-2"><a href="#"><img class="img-responsive" src="images/client/client.jpg" alt="Sarah Doe - Designer"></a></li>
									<li class="quote-3"><a href="#"><img class="img-responsive" src="images/client/client.jpg" alt="Sam Peterson - Developer"></a></li>
									<li class="quote-4"><a href="#"><img class="img-responsive" src="images/client/client.jpg" alt="John Smith - Developer"></a></li>
									<li class="quote-5"><a href="#"><img class="img-responsive" src="images/client/client.jpg" alt="Natasha Smith - Project Manager"></a></li>
									<li class="quote-6"><a href="#"><img class="img-responsive" src="images/client/client.jpg" alt="Jessica Doe - Designer"></a></li>
								</ul>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 col-lg-6 col-sm-pull-6 col-md-pull-6 col-lg-pull-6">
							<div class="quotes">
							<ul>
								<li class="quote-1 active">
									<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
									Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
								</li>
								<li class="quote-2">
									<p>when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, 
									but also the leap into electronic typesetting, remaining essentially unchanged.</p>
								</li>
								<li class="quote-3">
									<p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, 
									and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
								</li>
								<li class="quote-4">
									<p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
									when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
								</li>
								<li class="quote-5">
									<p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, 
									and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
								</li>
								<li class="quote-6">
									<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. 
									The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters</p>
								</li>
							</ul>
							</div>
						</div>
					</div>
				</div>
				</div>
			</section>
			<!-- /client -->
			
			<section class="section blog">
					<div class="container">
						<h1 class="h1">Our Blog</h1>
						<div class="row">
						
							<div class="col-sm-6 col-md-6 col-lg-6 blog-post">
								<article class="article">
									<div class="article-media">
										<a href="#"><img class="img-responsive" src="images/blog/blog-post1.jpg" alt="blog-article"></a>
									</div>
									<div class="article-body">
										<h4 class="h4 article-title"><a href="#">Example Blog Post</a></h4>
										
										<div class="article-tag"><i class="fa fa-tag"></i><a href="#">Dinner</a>
										<span class="separator">|</span><a href="#">Kitchen</a>
										<span class="separator">|</span><a href="#">Harvesting</a>
										</div>
										
										<p>when an unknown printer took a galley of type and scrambled it to make a type specimen book. 
										It has survived when an unknown printer type and specimen book.</p>
										
										<div class="read-more"><a href="#">Read More</a>
											<i class="fa fa-comment pull-right"> 08</i>
										</div>
									</div>
								</article>
							</div>
							<div class="col-sm-6 col-md-6 col-lg-6 blog-post">
								<article class="article">
									<div class="article-media">
										<a href="#"><img class="img-responsive" src="images/blog/blog-post2.jpg" alt="blog-article"></a>
									</div>
									<div class="article-body">
										<h4 class="h4 article-title"><a href="#">Example Blog Post</a></h4>
										
										<div class="article-tag"><i class="fa fa-tag"></i><a href="#">Dinner</a>
										<span class="separator">|</span><a href="#">Kitchen</a>
										<span class="separator">|</span><a href="#">Harvesting</a>
										</div>
										
										<p>when an unknown printer took a galley of type and scrambled it to make a type specimen book. 
										It has survived when an unknown printer type and specimen book.</p>
										
										<div class="read-more"><a href="#">Read More</a>
											<i class="fa fa-comment pull-right"> 08</i>
										</div>
									</div>
								</article>
							</div>
							<div class="col-sm-6 col-md-6 col-lg-6 blog-post">
								<article class="article">
									<div class="article-media">
										<a href="#"><img class="img-responsive" src="images/blog/blog-post3.jpg" alt="blog-article"></a>
									</div>
									<div class="article-body">
										<h4 class="h4 article-title"><a href="#">Example Blog Post</a></h4>
										
										<div class="article-tag"><i class="fa fa-tag"></i><a href="#">Dinner</a>
										<span class="separator">|</span><a href="#">Kitchen</a>
										<span class="separator">|</span><a href="#">Harvesting</a>
										</div>
										
										<p>when an unknown printer took a galley of type and scrambled it to make a type specimen book. 
										It has survived when an unknown printer type and specimen book.</p>
										
										<div class="read-more"><a href="#">Read More</a>
											<i class="fa fa-comment pull-right"> 08</i>
										</div>
									</div>
								</article>
							</div>
						
							<div class="col-sm-6 col-md-6 col-lg-6 blog-post">
								<article class="article">
									<div class="article-media">
										<a href="#"><img class="img-responsive" src="images/blog/blog-post4.jpg" alt="blog-article"></a>
									</div>
									<div class="article-body">
										<h4 class="h4 article-title"><a href="#">Example Blog Post</a></h4>
										
										<div class="article-tag"><i class="fa fa-tag"></i><a href="#">Dinner</a>
										<span class="separator">|</span><a href="#">Kitchen</a>
										<span class="separator">|</span><a href="#">Harvesting</a>
										</div>
										
										<p>when an unknown printer took a galley of type and scrambled it to make a type specimen book. 
										It has survived when an unknown printer type and specimen book.</p>
										
										<div class="read-more"><a href="#">Read More</a>
											<i class="fa fa-comment pull-right"> 08</i>
										</div>
									</div>
								</article>
							</div>
							<div class="col-sm-6 col-md-6 col-lg-6 blog-post">
								<article class="article">
									<div class="article-media">
										<a href="#"><img class="img-responsive" src="images/blog/blog-post5.jpg" alt="blog-article"></a>
									</div>
									<div class="article-body">
										<h4 class="h4 article-title"><a href="#">Example Blog Post</a></h4>
										
										<div class="article-tag"><i class="fa fa-tag"></i><a href="#">Dinner</a>
										<span class="separator">|</span><a href="#">Kitchen</a>
										<span class="separator">|</span><a href="#">Harvesting</a>
										</div>
										
										<p>when an unknown printer took a galley of type and scrambled it to make a type specimen book. 
										It has survived when an unknown printer type and specimen book.</p>
										
										<div class="read-more"><a href="#">Read More</a>
											<i class="fa fa-comment pull-right"> 08</i>
										</div>
									</div>
								</article>
							</div>
							<div class="col-sm-6 col-md-6 col-lg-6 blog-post">
								<article class="article">
									<div class="article-media">
										<a href="#"><img class="img-responsive" src="images/blog/blog-post6.jpg" alt="blog-article"></a>
									</div>
									<div class="article-body">
										<h4 class="h4 article-title"><a href="#">Example Blog Post</a></h4>
										
										<div class="article-tag"><i class="fa fa-tag"></i><a href="#">Dinner</a>
										<span class="separator">|</span><a href="#">Kitchen</a>
										<span class="separator">|</span><a href="#">Harvesting</a>
										</div>
										
										<p>when an unknown printer took a galley of type and scrambled it to make a type specimen book. 
										It has survived when an unknown printer type and specimen book.</p>
										
										<div class="read-more"><a href="#">Read More</a>
											<i class="fa fa-comment pull-right"> 08</i>
										</div>
									</div>
								</article>
							</div>

						</div>
					</div>
			</section> 
			<!-- /blog -->

            <section class="section contact">
				<div class="center-box">
					<div class="contact-holder">
						<div class="container">
							<div class="row">
                            
                            	<div class="col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
									<div class="contact-box">
                                         <h3 class="h3 lead">Think we might help?</h3>
                                         <h3 class="h3 lead">We’d love to hear from you.</h3>
                                        <a data-toggle="modal" class="submit btn btn-info btn-block" role="button" href="#contact">Write for us</a>
                                    </div>
                               		<div class="contact-box">
										 <h3 class="h3">Where we are</h3>
										 <address>
											ThemeArt<br>
											33 Street Name<br>
											New York, NY 12345<br>
										 </address>
										 <address>
											<i class="fa fa-phone"></i> <abbr title="Phone">P:</abbr> (123) 456-789
										 </address>
										 
										 <address>
											Contact :<br>
											<i class="fa fa-envelope-o"></i> <a href="mailto:#">info@quickmetro.com</a>
										 </address>
										 
									 </div>
								</div>	
                            
							</div>
						</div>
					</div>
				</div>
				<div id="map"></div>
            </section> 
			<!-- /contact -->

			<section class="section follow">
				<div class="center-box">
					<div class="container">
						
						<div class="row">
							<div class="socialize">
								<h2 class="h2">See you soon!</h2>
							</div>
						</div>
						
						<div class="row">
							<ul id="social-networks">
								<li class="social-twitter"><a href="https://twitter.com/" target="_blank"><i class="fa fa-twitter fa-4x"></i></a></li>
								<li class="social-facebook"><a href="http://www.facebook.com" target="_blank"><i class="fa fa-facebook fa-4x"></i></a></li>
								<li class="social-googleplus"><a href="http://www.google.com" target="_blank"><i class="fa fa-google-plus fa-4x"></i></a></li>
								<li class="social-youtube"><a href="http://www.youtube.com" target="_blank"><i class="fa fa-youtube fa-4x"></i></a></li>
								<li class="social-pinterest"><a href="http://www.pinterest.com" target="_blank"><i class="fa fa-pinterest fa-4x"></i></a></li>
								<li class="social-dribbble"><a href="http://www.dribbble.com" target="_blank"><i class="fa fa-dribbble fa-4x"></i></a></li>
								<li class="social-linkedin"><a href="http://www.linkedin.com" target="_blank"><i class="fa fa-linkedin fa-4x"></i></a></li>
								<li class="social-flickr"><a href="http://www.flickr.com" target="_blank"><i class="fa fa-flickr fa-4x"></i></a></li>
							</ul>
						</div>
						
					</div>
				</div>
			</section> 
			<!-- /follow -->
			
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