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
						<li class="users-menu"><a class="ascensorLink ascensorLink3" href="#">Users</a></li>
						<li class="profile-menu"><a class="ascensorLink ascensorLink4" 	 href="#">My Profile</a></li>
						<li class="profile-menu"><a class="ascensorLink ascensorLink5" 	 href="#">Faculties</a></li>
						<li class="profile-menu"><a class="ascensorLink ascensorLink6" 	 href="#">Departments</a></li>
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
						<div class="tile tile-item tile-users">
							<a class="ascensorLink ascensorLink3 tile-nav" href="#">
								<h5 class="h5">Users</h5>
								<i class="fa fa-group fa-4x"></i>
							</a>
						</div>
						<div class="tile tile-item tile-profile">
							<a class="ascensorLink ascensorLink4 tile-nav" href="#">
								<h5 class="h5">My Profile</h5>
								<i class="fa fa-sitemap fa-4x"></i>
							</a>
						</div>
						<div class="tile tile-item tile-faculty">
							<a class="ascensorLink ascensorLink5 tile-nav" href="#">
								<h5 class="h5">Faculties</h5>
								<i class="fa fa-sitemap fa-4x"></i>
							</a>
						</div>
						<div class="tile tile-item tile-departments">
							<a class="ascensorLink ascensorLink6 tile-nav" href="#">
								<h5 class="h5">Departments</h5>
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
			
			
			<!-- /service -->
			
            <section class="section team">
					<div class="container">
						<h1 class="h1">Users</h1>
						<div class="col-lg-12">
							<div class="profile">
								<h3>Create Users</h3>
								<form action="" method="POST" id="createUsersCSV" enctype="multipart/form-data">
									<label>Select File:</label><input type="file" class="form-control" id="usersCSV" name="usersCSV" required/>
									<button type="submit" class="btn btn-primary" style="margin-top:10px;">Create Users</button>
								</form>
							</div>
						</div>
            </section>

			<!-- /team -->

			<section class="section about">
				<div class="container">
					<h1 class="h1">My Profile</h1>						
					<div class="row">
						<div class="col-lg-12">
							<div class="profile" style="padding-bottom:50px;">
								<h1>{{ Auth::user()->name }}</h1>
									<table>
										<tbody>
											<tr>
												<th><b>Technician ID:</b></th>
												<td colspan="1">{{ Auth::user()->username }}</td>
											</tr>
											<tr>
												<th><b>Email:</b></th>
												<td colspan="1">{{ Auth::user()->email }}</td>
											</tr>
										</tbody>
									</table>
								<div class="skill-q" id="changePass" style="border-top: 1px solid;">
									<p>Change Password</p>
									<a data-toggle="modal" class="submit btn btn-info btn-block" role="button" href="#contact">Change Password Now</a>
								</div>
								@if(Session::has('pass'))
									<div class="globalU warn arrowU">{{ Session::get('global') }}</div>
								@endif
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
				</div>
            </section>
            <section class="section about">
				<div class="container">
						<h1 class="h1">Faculties</h1>
						<div id="facultyContainer"> 
							<div class="col-sm-4">
								<a data-toggle="modal" role="button" href="#newFaculty">
									<div class="feature-box">
										<div class="faculty">
											<div class="faculty-box">
												<span>Create New Faculty</span>
											</div>
										</div>
									</div>
								</a>
							</div>
							<div class="modal fade" id="newFaculty" tabindex="-1" role="dialog" aria-hidden="true">
								<div class="modal-dialog">
									<div  class="contact-box">
							        	<button type="button" class="close" data-dismiss="modal" aria-hidden="true" class="faculty-close">&times;</button>
							            <form id="createFaculty" action="" method="post">
							                <label>Faculty Name:</label><input type="text" class="form-control" id="name" placeholder="Faculty Name" required/>
											<label>Faculty Shortname:</label><input type="text" class="form-control" id="shortname" placeholder="Faculty Shortname" required/>
											<label>Faculty Description:</label><textarea id="description" class="form-control" rows="5" required placeholder="Faculty Description"></textarea>
											<button type="submit" class="btn btn-primary" style="margin-top:10px;">Create Faculty</button>
							            </form>
									</div>
								</div>
							</div>
							@foreach(Faculty::all() as $faculty)
								<div class="col-sm-4">
									<a data-toggle="modal" role="button" id="faculty{{ $faculty->facultyid }}" href="#editFaculty{{ $faculty->facultyid }}">
										<div class="feature-box">
											<div class="faculty">
												<div class="faculty-box">
													<span>{{ $faculty->facultyname }}</span>
												</div>
											</div>
										</div>
									</a>
								</div>
								<div class="modal fade" id="editFaculty{{ $faculty->facultyid }}" tabindex="-1" role="dialog" aria-hidden="true">
									<div class="modal-dialog">
										<div  class="contact-box">
								        	<button type="button" class="close" data-dismiss="modal" aria-hidden="true" class="faculty-close">&times;</button>
							                <form class="editFaculty" action="" method="post">
							                	<label>Faculty Name:</label><input type="text" class="form-control" id="name" placeholder="Faculty Name" value="{{ $faculty->facultyname }}" required/>
												<label>Faculty Shortname:</label><input type="text" class="form-control" id="shortname" placeholder="Faculty Shortname" value="{{ $faculty->facultyshort }}" required/>
												<label>Faculty Description:</label><textarea id="description" class="form-control" rows="5" required placeholder="Faculty Description">{{ $faculty->facultydescription }}</textarea>
												<input type="hidden" id="facultyid" value="{{ $faculty->facultyid }}" />
												<button type="submit" class="btn btn-primary" style="margin-top:10px;">Update Faculty</button>
								            </form>
										</div>
									</div>
								</div>
							@endforeach
						</div>
					</div>
            </section>
            <section class="section about">
				<div class="container">
						<h1 class="h1">Departments</h1>
						<div id="departmentContainer"> 
							<div class="col-sm-4">
								<a data-toggle="modal" role="button" href="#newDepartment">
									<div class="feature-box">
										<div class="department">
											<div class="department-box">
												<span>Create New Department</span>
											</div>
										</div>
									</div>
								</a>
							</div>
							<div class="modal fade" id="newDepartment" tabindex="-1" role="dialog" aria-hidden="true">
								<div class="modal-dialog">
									<div  class="contact-box">
							        	<button type="button" class="close" data-dismiss="modal" aria-hidden="true" class="department-close">&times;</button>
							            <form id="createDepartment" action="" method="post">
							                <label>Department Name:</label><input type="text" class="form-control" id="name" placeholder="Department Name" required/>
											<label>Department Shortname:</label><input type="text" class="form-control" id="shortname" placeholder="Department Shortname" required/>
											<label>Department Head:</label><input type="text" class="form-control" id="head" placeholder="Department Head" required/>
											<label>Department Description:</label><textarea id="description" class="form-control" rows="5" required placeholder="Department Description"></textarea>
											<label for='facultyId'>Faculty:</label><select id="facultyId" class="form-control faculty-list">
												@foreach(Faculty::all() as $faculty)
													<option value="{{ $faculty->facultyid}}" >{{ $faculty->facultyname }}</option>
												@endforeach
												</select>
											<button type="submit" class="btn btn-primary" style="margin-top:10px;">Create Department</button>
							            </form>
									</div>
								</div>
							</div>
							@foreach(Departments::all() as $department)
								<div class="col-sm-4">
									<a data-toggle="modal" role="button" id="department{{ $department->deparmentid }}" href="#editDepartment{{ $department->departmentid }}">
										<div class="feature-box">
											<div class="department">
												<div class="department-box">
													<span>{{ $department->departmentname }}</span>
												</div>
											</div>
										</div>
									</a>
								</div>
								<div class="modal fade" id="editDepartment{{ $department->departmentid }}" tabindex="-1" role="dialog" aria-hidden="true">
									<div class="modal-dialog">
										<div  class="contact-box">
								        	<button type="button" class="close" data-dismiss="modal" aria-hidden="true" class="faculty-close">&times;</button>
							                <form class="editDepartment" action="" method="post">
							                	<label>Department Name:</label><input type="text" class="form-control" id="name" placeholder="Department Name" value="{{ $department->departmentname }}" required/>
												<label>Department Shortname:</label><input type="text" class="form-control" id="shortname" placeholder="Department Shortname" value="{{ $department->departmentshort }}" required/>
												<label>Department Head:</label><input type="text" class="form-control" id="head" placeholder="Department Head" value="{{ $department->departmenthead }}" required/>
												<label>Department Description:</label><textarea id="description" class="form-control" rows="5" required placeholder="Faculty Description">{{ $department->departmentdescription }}</textarea>
												<label for='facultyId'>Faculty:</label><select id="facultyId" class="form-control faculty-list">
												@foreach(Faculty::all() as $faculty)
													<option value="{{ $faculty->facultyid }}" {{ ($faculty->facultyid == $department->facultyid) ? 'selected' : '' }}>{{ $faculty->facultyname }}</option>
												@endforeach
												</select>
												<input type="hidden" id="departmentid" value="{{ $department->departmentid }}" />
												<button type="submit" class="btn btn-primary" style="margin-top:10px;">Update Department</button>
								            </form>
										</div>
									</div>
								</div>
							@endforeach
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