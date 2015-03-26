<!Doctype html>
<html lang="en-US">
	<head>
	
		<!-- ==============================================
		Title and basic Metas
		=============================================== -->
        <meta charset="utf-8">
        <title>Lecturer | Module Enrollment System</title>
		<meta namfe="description" content="Lecturer | Module Enrollment System">
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
						<li class="electives-menu"><a class="ascensorLink ascensorLink1" href="#">Electives</a></li>
						<li class="profile-menu"><a class="ascensorLink ascensorLink2" href="#">Profile</a></li>
						<li class="signout-menu"><a class="ascensorLink" href="{{ URL::route('account-sign-out') }}">Sign out</a></li>
					</ul>
				</div>
            </div>
        </nav> <!-- /navbar -->
		
		<div id="ascensor">
		
			<section class="section home">
				<div class="center-box">
					@if(Session::has('global'))
							<div class="globalD arrowD">{{ Session::get('global') }}</div>
					@endif
					<div class="container">
	
						<div class="tile tile-item tile-electives">
							<a class="ascensorLink ascensorLink1 tile-nav" href="#">
								<h5 class="h5">Electives</h5>
								<i class="fa fa-windows fa-4x"></i>
							</a>
						</div>
						<div class="tile tile-item tile-profile">
							<a class="ascensorLink ascensorLink2 tile-nav" href="#">
								<h5 class="h5">Profile</h5>
								<i class="fa fa-heart fa-4x"></i>
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

					    var list = $("#grid");
					    list.empty();
					    $(document).bind('ajaxStart', function(){
						    $(".load.Elec").show();
						}).bind('ajaxStop', function(){
						    $(".load.Elec").hide();
						});
					        $.ajax({
					            type: "GET",
					            url: "electives",
					            success:function(modules)
					            {
					                list.append(modules);
					                list.mixitup();
					                $("#grid li a ").each(function() { 
										$(this).hoverdir(); 
									});
					            }
					        });
					});
				</script>

				<!-- End of Filtering system -->
			</section>
			<!-- /portfolio -->
			
			<section class="section about">
				<div class="container">
					<h1 class="h1">Profile</h1>						
					<div class="row">
					
						<div class="col-sm-6 col-md-8 col-lg-8">
							<div class="profile">
								<h1>{{ Auth::user()->name }}</h1>
									<table>
										<tbody>
											<tr>
												<th><b>Lecturer ID:</b></th>
												<td colspan="1">{{ Auth::user()->username }}</td>
											</tr>
											<tr>
												<th><b>Department:</b></th>
												<td colspan="1">{{ Departments::find(Auth::user()->department)->name() }}</td>
											</tr>
											<tr>
												<th><b>Number of Classes:</b></th>
												<td colspan="1">{{ count(Classes::where('classlecturer', Auth::user()->id)->get()) }}</td>
											</tr>
										</tbody>
									</table>
							</div>
						</div>
							
						<div class="col-sm-6 col-md-4 col-lg-4">
							<div class="profile settings">
								<h4 class="h4">Settings</h4>
								<div class="skill-q" id="changePass">
									<p>Change Password</p>
									<a data-toggle="modal" class="submit btn btn-info btn-block" role="button" href="#contact">Change Password Now</a>
								</div>
								@if(Session::has('pass'))
									<div class="globalU warn arrowU">{{ Session::get('pass') }}</div>
								@endif
							</div>
						</div>
					</div>
					@extends('account.password')
					<div class="row">
						<hr class="metro-hr">
						<h2 class="h2 lead">Classes</h2>
						@if(Classes::where('classlecturer', Auth::user()->id)->count() > 0)
							<div class="col-lg-12">
								<div class="profile">
									@include('layout.classes')
							@else
							<div class="col-lg-12">
								<div class="profile">
									No Classes Found.
								</div>
							</div>
							@endif
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