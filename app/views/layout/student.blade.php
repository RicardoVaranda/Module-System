<!Doctype html>
<html lang="en-US">
	<head>
	
		<!-- ==============================================
		Title and basic Metas
		=============================================== -->
        <meta charset="utf-8">
        <title>Student | Module Registration System</title>
		<meta name="description" content="Student | Module Registration System">
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
    	<div class="message">
    	</div>
	
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
						<li class="timetable-menu"><a class="ascensorLink ascensorLink3" href="#">Timetable</a></li>
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
						<div class="tile tile-item tile-timetables">
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
				<div class="load Elec" style="display:none;"></div>
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
						<div id="grid">
						</div>
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
			<!-- /electives -->
			
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
												<th><b>Student ID:</b></th>
												<td colspan="1">{{ Auth::user()->username }}</td>
											</tr>
											<tr>
												<th><b>Degree:</b></th>
												<td colspan="1">Ordinary Bachelor Degree</td>
											</tr>
											<tr>
												<th><b>Major:</b></th>
												<td colspan="1">{{ Departments::find(Auth::user()->department)->name() }}</td>
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
						<h2 class="h2 lead">My Electives</h2>
							<div id="myelectives">
								<?php 
									// Get the electives.
									$electives = Auth::user()->electives;
									// Make sure we actually got something.
									if($electives != null) {
										foreach(json_decode($electives) as $elec) { ?>
											@include('layout.myelectives', array('elec' => $elec))
									<?php	}
									}
								?>
						<hr class="metro-hr">
					</div>
						
				</div>
            </section> 
			<!-- profile -->
			
			<section class="section timetable">  
				<div class="container">	
					<h1 class="h1">Timetables</h1>
					
					<div class="row">
						<hr class="metro-hr">
						<div class="col-sm-9">
							<input type="text" name="electimes" id="elective" list="electives" class="form-control" placeholder="Choose Elective Module to view Timetable" required="">
							<datalist id="electives">
							   <select onchange="$('#elective').val(this.value)">
							   <?php 
							   		$electives = Auth::user()->electives;

									if($electives != null) {
										$electives = json_decode($electives);
										//Search for current elective.
										foreach($electives as $key => $value) {
											$elec= Classes::find($value->classId);
											$mod= Modules::find($elec->classmodule);
											print('<option label="'.$mod->mshorttitle.'" value="'.$elec->classid.'"></option>');
										}
									}
							    ?>
							   </select>
							</datalist>
						</div>
						<div class="col-sm-3">
							<ul class="check-our-work">
								<a data-toggle="modal" class="submit btn btn-info btn-block" role="button" id="loadTimes">Load Timetable</a>
							</ul>
						</div>
						<hr class="metro-hr">
					</div>

					<div class="row" id="timetableRow">
						
					</div>
					<hr class="metro-hr">
				</div>
			</section> 
			<!-- /timetable -->	

			<script type="text/javascript">

			$("#loadTimes").click(function() {
						var opt = $('option[value="'+$('#elective').val()+'"]');
						if(!opt.length){
							alert('Error: No Elective Selected.')
							return;
						}

						$.get("timetables/"+$('#elective').val()).done(function(data){
							$("#timetableRow").empty();
							$("#timetableRow").html(data);
						});			
					});

			function loadTime($id){
				$.get("timetables/"+$id).done(function(data){
							$("#timetableRow").empty();
							$("#timetableRow").html(data);
						});	
			}
			</script>
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
