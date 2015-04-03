<?php
	// Get the module.
	$mod = Modules::where('mid', $elec->classmodule)->first();
?>
<li class="mix {{ $mod->department->faculty->short() }} {{ $mod->department->short() }}"> 
	<a data-toggle="modal" role="button" href="#{{$mod->mcode}}"> <img src="{{URL::route('getImg', $mod->mcode)}}" alt="portfolio">
		<div><span>{{ $mod->mshorttitle }}</span></div>
	</a>
	<div class="modal fade" id="{{$mod->mcode}}" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
		  	<div class="modal-content">
				<div class="modal-header">
			  		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			  		<h3 class="h3 modal-title">{{ $mod->mfulltitle }}</h3>
				</div>
				<div class="modal-body">
					<div class="container">
						<div class="row">
							<div class="col-sm-8">
								<img src="{{URL::route('getImg', $mod->mcode)}}" class="img-responsive" alt="portfolio">
								<?php
								if(Auth::user()->rank < 1) {
								// Extract current user's electives.
								$electives = Auth::user()->electives;

								$registered = false;
								// Make sure we got a result.
								if($electives != null) {
									$electives = json_decode($electives);
									//Search for current elective.
									foreach($electives as $key => $value) {
										if($value->electiveId == $mod->mid){
											$registered = true;
										}
									}
								}

								// Now print forms.
								if($registered) { ?>
									<form class="electiveUnregister" action="" method="POST">
									<input type="hidden" id="electiveId" value="{{ $mod->mid }}" />
									<button type="submit" class="btn-primary elective-btn" id="registration{{ $mod->mid }}">Unregister</button>
								</form>
								<?php } else { ?>
									<form class="electiveRegister" action="" method="POST">
										<input type="hidden" id="electiveId" value="{{ $mod->mid }}" />
										<button type="submit" class="btn-primary elective-btn" id="registration{{ $mod->mid }}">Register</button>
									</form>
								<?php } } ?>
							</div>
							<div class="col-sm-4">
								<div class="modal-entery">
									<p>{{ $mod->mdescription }}</p>
									<h4 class="h4">Lecturer</h4>
									{{ $mod->mcoordinator }}
									<h4 class="h4">Field of Study</h4>
									{{ $mod->mfieldofstudy }}
									<h4 class="h4">Module Level</h4>
									{{ $mod->mlevel }}
									<h4 class="h4">Module Credits</h4>
									{{ $mod->mcredits }}
									<?php
									// Let's define what semester we are in.
									$today = date('Y-m-d');
									$semester = date('Y-m-d', strtotime(date('Y', strtotime($today)).'-06-01'));
									// If current date is greater than semester 2
									// Change current to semester 1.
									if($today > $semester) {
										// Get next year.
										$year = date('Y',strtotime(date("Y-m-d", time()) . " + 365 day"));
										$semester = date('Y-m-d', strtotime($year.'-01-01'));
									}
									// Let's get the total spaces in elective.
									$spaces = 0;
									$classes = Classes::where('classmodule', $mod->mid)->get();
									foreach($classes as $c){
										
										// Check if this class belongs to this year.
										if(date('Y', strtotime($c->created)) === date('Y', strtotime($today))) {
											// Now check that it is part of this semester.
											if(date('Y-m-d', strtotime($c->created)) < $semester) {
												$spaces+=($c->classlimit-$c->classcurrent);
											}
										}
									}
									?>
									<h4 class="h4">Spaces Available</h4>
									<span id="elective{{ $mod->mid }}">{{ $spaces }}</span>
								</div>
							</div>
						</div>
					</div>
				</div>
		  	</div>
		</div>
	</div>
</li>
