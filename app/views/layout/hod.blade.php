<!Doctype html>
<html lang="en-US">
	<head>
	
		<!-- ==============================================
		Title and basic Metas
		=============================================== -->
        <meta charset="utf-8">
        <title>CIT Modules :: Module System</title>
		<meta name="description" content="CIT Module System" />
		
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
		{{ HTML::script('./js/test.js') }}
        
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
						<li class="modules-menu"><a class="ascensorLink ascensorLink1" href="#">Modules</a></li>
						<li class="electives-menu"><a class="ascensorLink ascensorLink2" href="#">Electives</a></li>
						<li class="timetables-menu"><a class="ascensorLink ascensorLink3" href="#">Timetables</a></li>
						<li class="lecturers-menu"><a class="ascensorLink ascensorLink4" href="#">Lecturers</a></li>
						<li class="profile-menu"><a class="ascensorLink ascensorLink5" href="#">Profile</a></li>
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
						
						<div class="tile tile-item tile-modules">
							<a class="ascensorLink ascensorLink1 tile-nav" href="#">
								<h5 class="h5">Modules</h5>
								<i class="fa fa-heart fa-4x"></i>
							</a>
						</div>
						<div class="tile tile-item tile-electives">
							<a class="ascensorLink ascensorLink2 tile-nav" href="#">
								<h5 class="h5">Electives</h5>
								<i class="fa fa-windows fa-4x"></i>
							</a>
						</div>
						<div class="tile tile-item tile-lecturers">
							<a class="ascensorLink ascensorLink3 tile-nav" href="#">
								<h5 class="h5">Timetables</h5>
								<i class="fa fa-group fa-4x"></i>
							</a>
						</div>
						<div class="tile tile-item tile-lecturers">
							<a class="ascensorLink ascensorLink4 tile-nav" href="#">
								<h5 class="h5">Lecturers</h5>
								<i class="fa fa-group fa-4x"></i>
							</a>
						</div>
						<div class="tile tile-item tile-profile">
							<a class="ascensorLink ascensorLink5 tile-nav" href="#">
								<h5 class="h5">Profile</h5>
								<i class="fa fa-sitemap fa-4x"></i>
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
			
			<section class="section modules">
				<div class="load Mod"></div>
				<div class="container">
					<h1 class="h1">Modules</h1>
					<!-- Display all electives, add a new electives button, in that button open up a list of modules so that we can select the module that we want to create as an elective -->
					<div class="row">
						<div class="grid-controls">
							  	<select class="dep styled-select blue semi-square" id="searchMods">
									<option label="All" value="all"></option>
									@foreach(Modules::where('departmentid', Auth::user()->department)->get() as $mod)
									<option label="{{$mod->mshorttitle}}" value="{{$mod->mid}}"></option>
									@endforeach
								</select>
							</datalist>
						</div>
						<ul id="grid" class="mod">
						</ul>
					</div>
				</div> 
				<!-- Custom JQuery Ajax Next level system - Ricardo -->

				<script type="text/javascript">
					$(document).ready(function(){
					    var list = $("#grid.mod");
					    list.empty();
					    $(document).bind('ajaxStart', function(){
						    $(".load.Mod").show();
						}).bind('ajaxStop', function(){
						    $(".load.Mod").hide();
						    $("#searchMods").show();
						});
					        $.ajax({
					            type: "POST",
					            url: "modules",
					            success:function(modules)
					            {
					                list.append(modules);
					                list.mixitup();
					                $("#grid.mod li a ").each(function() { 
										$(this).hoverdir(); 
									});


									$("#newForm").submit(function(e){
						                e.preventDefault();
						                var form = $(this); 
						                var errors = document.getElementsByClassName('isa_error');

									    for (var i = 0; i < errors.length; i++){
									        errors[i].style.display = 'none';
									    }
						                $.ajax({
						                    type: "POST",
						                    url : form.attr("action"),
						                    data : {modData: form.serialize()},
						                    headers: {
										        'X-CSRF-Token': $('input[name="_token"]').val()
										    }
						                })
										.done(function(data){
											if(data.fail){
												$.each(data.errors, function( index, value ) {
											        var errorDiv = $('#newForm #'+index+'_Errors');
											        errorDiv.empty();
											        errorDiv.append('<i class="fa fa-times-circle"></i>'+value);
											        errorDiv.show();
											    });
										      $('#successMessage').empty();    
											} else {
												$('#newMod .close').click(); //hiding form

												setTimeout(function() { loadModules(); }, 1000);
												
											}
										});

					        		});


									$("#editForm").submit(function(e){
						                e.preventDefault();
						                var form = $(this); 
						                var errors = document.getElementsByClassName('isa_error');

									    for (var i = 0; i < errors.length; i++){
									        errors[i].style.display = 'none';
									    }
						                $.ajax({
						                    type: "POST",
						                    url : form.attr("action"),
						                    data : {modData: form.serialize()},
						                    headers: {
										        'X-CSRF-Token': $('input[name="_token"]').val()
										    }
						                })
										.done(function(data){
											if(data.fail){
												$.each(data.errors, function( index, value ) {
											        var errorDiv = form.find('#'+index+'_Errors');
											        errorDiv.empty();
											        errorDiv.append('<i class="fa fa-times-circle"></i>'+value);
											        errorDiv.show();
											    });
										      $('#successMessage').empty();    
											} else {
												$('#newMod .close').click(); //hiding form

												//FIX THIS
												//setTimeout(function() { loadModules(); }, 1000);
												
											}
										});

					        		});

					            }
					        });
					});
				</script>

				<!-- End of Ajax system -->
			</section>
			<!-- /modules -->

			<section class="section electives">
				<div class="load Elec"></div>
				<div class="container">
					<h1 class="h1">Electives</h1>
					<!-- Display all electives, add a new electives button, in that button open up a list of modules so that we can select the module that we want to create as an elective -->
					<div class="row">
						<div class="grid-controls">
							  	<select class="elec styled-select blue semi-square" id="searchElecs">
									<option label="All" value="all"></option>
									@foreach(Classes::all() as $elec)
									<?php $mod = Modules::find($elec->classmodule); ?>
										@if ($mod->departmentid ==  Auth::user()->department)
											<option label="{{$mod->mshorttitle}}" value="{{$elec->classid}}"></option>
										@endif
									@endforeach
								</select>
							</datalist>
						</div>
						<ul id="grid" class="electives">
						</ul>
					</div>
				</div>
				<!-- Custom JQuery Ajax Next level system - Ricardo -->

				<script type="text/javascript">
					$(document).ready(function(){
					    var list = $("#grid.electives");
					    list.empty();
					    $(document).bind('ajaxStart', function(){
						    $(".load.Elec").show();
						}).bind('ajaxStop', function(){
						    $(".load.Elec").hide();
						    $("#searchElecs").show();
						});
					        $.ajax({
					            type: "POST",
					            url: "electives",
					            success:function(electives)
					            {
					                list.append(electives);
					                list.mixitup();
					                $("#grid.electives li a ").each(function() { 
										$(this).hoverdir(); 
									});

									$("#newFormElec").submit(function(e){
						                e.preventDefault();
						                var form = $(this); 
						                var errors = document.getElementsByClassName('isa_error');

									    for (var i = 0; i < errors.length; i++){
									        errors[i].style.display = 'none';
									    }
						                $.ajax({
						                    type: "POST",
						                    url : form.attr("action"),
						                    data : {elecData: form.serialize()},
						                    headers: {
										        'X-CSRF-Token': $('input[name="_token"]').val()
										    }
						                })
										.done(function(data){
											if(data.fail){
												$.each(data.errors, function( index, value ) {
											        var errorDiv = $('#newFormElec #'+index+'_Errors');
											        errorDiv.empty();
											        errorDiv.append('<i class="fa fa-times-circle"></i>'+value);
											        errorDiv.show();
											    });
										      $('#successMessage').empty();    
											} else {
												$('#newElec .close').click(); //hiding form

												setTimeout(function() { loadModules(); }, 1000);
												
											}
										});

					        		});


									$("#editFormElec").submit(function(e){
						                e.preventDefault();
						                var form = $(this); 
						                var errors = document.getElementsByClassName('isa_error');

									    for (var i = 0; i < errors.length; i++){
									        errors[i].style.display = 'none';
									    }
						                $.ajax({
						                    type: "POST",
						                    url : form.attr("action"),
						                    data : {elecData: form.serialize()},
						                    headers: {
										        'X-CSRF-Token': $('input[name="_token"]').val()
										    }
						                })
										.done(function(data){
											if(data.fail){
												$.each(data.errors, function( index, value ) {
											        var errorDiv = form.find('#'+index+'_Errors');
											        errorDiv.empty();
											        errorDiv.append('<i class="fa fa-times-circle"></i>'+value);
											        errorDiv.show();
											    });
										      $('#successMessage').empty();    
											} else {
												$('#newElec .close').click(); //hiding form
												//FIX THIS 
												//setTimeout(function() { loadModules(); }, 1000);
												
											}
										});

					        		});

					            }
					        });
					});
				</script>

				<!-- End of Ajax system -->
			</section>
			<!--Electives -->
			
			<section class="section timetables">  
				<div class="container">	
					<h1 class="h1">Timetables</h1>
					
					<div class="row">
						<hr class="metro-hr">
						<div class="col-sm-9">
							<input type="text" name="electimes" id="elective" list="electives" class="form-control" placeholder="Elective Module" required="">
							<datalist id="electives">
							   <select onchange="$('#elective').val(this.value)">
								   <option value="Maths and Music" label="1"></option>
							   </select>
							</datalist>

							<div id="numClasses"></div>

							<br>
							<div id="classTimes">
							</div>
						</div>
						<div class="col-sm-3">
							<ul class="check-our-work">
								<a data-toggle="modal" class="submit btn btn-info btn-block" role="button" id="loadTT">Load Timetable</a>
							</ul>
						</div>
						<hr class="metro-hr">
					</div>

					<div class="row">
						<div class="col-sm-12 custTable">
							    <table id="timetable" class="heavyTable">
							    	<thead>
							    		<tr>
							    			<th colspan="6"><h1>Maths and Music</h1><h4>Spaces Available: <div id="spacesAvailable">DynamicUpdateThis</div></h4></th>
							    		</tr>
							    	</thead>
									<thead>
										<tr id="days">
											<th></th>
											<th>Monday</th>
											<th>Tuesday</th>
											<th>Wednesday</th>
											<th>Thursday</th>
											<th>Friday</th>
										</tr>
									</thead>
									<tbody>
										<tr id="9">
											<td class="time">9:00</td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr id="10">
											<td class="time">10:00</td>
											<td></td>
										  	<td></td>
										  	<td></td>
										  	<td></td>
										  	<td></td>
										</tr>
										<tr id="11">
										  	<td class="time">11:00</td>
										  	<td></td>
										  	<td></td>
										  	<td></td>
										  	<td></td>
										  	<td></td>
										</tr>
										<tr id="12">
										  	<td class="time">12:00</td>
										  	<td></td>
										  	<td></td>
										  	<td></td>
										  	<td></td>
										  	<td></td>
										</tr>
										<tr id="13">
										  	<td class="time">13:00</td>
										  	<td></td>
										  	<td></td>
										  	<td></td>
										  	<td></td>
										  	<td></td>
										</tr>
										<tr id="14">
										  	<td class="time">14:00</td>
										  	<td></td>
										  	<td></td>
										  	<td></td>
										  	<td></td>
										  	<td></td>
										</tr>
										<tr id="15">
										  	<td class="time">15:00</td>
										  	<td></td>
										  	<td></td>
										  	<td></td>
										  	<td></td>
										  	<td></td>
										</tr>
										<tr id="16">
										  	<td class="time">16:00</td>
										  	<td></td>
										  	<td></td>
										  	<td></td>
										  	<td></td>
										  	<td></td>
										</tr>
										<tr id="17">
										  	<td class="time">17:00</td>
										  	<td></td>
										  	<td></td>
										  	<td></td>
										  	<td></td>
										  	<td></td>
										</tr>
									</tbody>
							    </table>
						</div>
					</div>
					<hr class="metro-hr">
				</div>
			</section> 
			<!-- /service -->
			
            <section class="section team">
					<div class="container">
						<h1 class="h1">Lecturers</h1>
						<div id="lecturerContainer"> 
							<div class="col-sm-4">
								<a data-toggle="modal" role="button" href="#newLecturer">
									<div class="feature-box">
										<div class="lecturer">
											<div class="lecturer-box">
												<span>Create New Lecturer</span>
											</div>
										</div>
									</div>
								</a>
							</div>
							<div class="modal fade" id="newLecturer" tabindex="-1" role="dialog" aria-hidden="true">
								<div class="modal-dialog">
									<div  class="contact-box">
							        	<button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="lecturer-close">&times;</button>
							            <form name="contactform" id="createLecturer" action="" method="post">
							                <label>Lecturer Name:</label><input type="text" class="form-control" id="lecturerName" placeholder="Lecturer Name" required/>
											<label>Lecturer ID:</label><input type="text" class="form-control" id="lecturerId" placeholder="Lecturer ID" required/>
											<label>Lecturer Email:</label><input type="email" class="form-control" id="lecturerEmail" placeholder="Lecturer Email" required/>
											<button type="submit" class="btn btn-primary" style="margin-top:10px;">Create Lecturer</button>
							            </form>
									</div>
								</div>
							</div>
							<?php $counter = 1; ?>
							@foreach(User::where('rank', 1)->where('department', Auth::user()->department)->get() as $lecturer)
								<?php if($counter == 3) {
									$counter = 0; ?>
									<div class="col-sm-4 clear" id="lecturer{{ $lecturer->id }}">
								<?php } else { ?>
									<div class="col-sm-4" id="lecturer{{ $lecturer->id }}">
								<?php 
									$counter++;
									} ?>
								<div class="feature-box">
									<div class="feature-text">
										<h3>Name: {{ $lecturer->name }}</h3>
										<p>Lecturer ID: {{ $lecturer->username }}</p>
										<p>Email:</p> <p>{{ $lecturer->email }}</p>
										<form class="removeLecturer" action="" method="POST">
											<input type="hidden" id="lecturerId" value="{{ $lecturer->id }}" />
											<button type="submit" class="btn btn-primary"><i class="fa fa-arrow-right"></i>Remove</button>
										</form>
									</div>
								</div>
							</div>
							@endforeach
						</div>
					</div>
            </section> 
			<!-- /team -->

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