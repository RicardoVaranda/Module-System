<label>Select Class:</label>
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
	$class = null;
?>
<select id="class-Select" class="form-control">
	<?php foreach(Classes::where('classlecturer', Auth::user()->id)->get() as $c) {
		// Check if this class belongs to this year.
		if(date('Y', strtotime($c->created)) === date('Y', strtotime($today))) {
			// Now check that it is part of this semester.
			if(date('Y-m-d', strtotime($c->created)) < $semester) {
				if(!isset($class)) {
					$class = $c;
				}
				$elective = Modules::where('mid', $c->classmodule)->first(); ?>
				<option value="{{ $c->classid }}">{{ $elective->mshorttitle }}</option>
			<?php }
		} 
	} ?>
</select>
<br>
<form action="" method="POST" id="classForm">
	<label>Space Limit:</label><input type="text" class="form-control" id="classlimit" placeholder="Class Space Limit" value="{{ $class->classlimit }}" />
	<label>Space Left:</label><input type="text" class="form-control" id="classleft" placeholder="Space Left in Class" value="{{ ($class->classlimit - $class->classcurrent) }}" disabled/>
	<input type="hidden" id="classId" value="{{ $class->classid }}"/>
		<div style="margin-top:10px">
			<button type="submit" class="btn btn-info pink">Update Class</button>	
                        <a onclick="event.preventDefault(); window.open('{{URL::route('getList', $class->classid)}}', '_blank')" target="_blank"><button class="btn btn-info pink">Download List</button></a>
       	                <a id="classAll" target="_blank" onclick="event.preventDefault(); window.open('https://mail.google.com/mail?view=cm&tf=0%22+&to={{ Classes::find($class->classid)->getEmails() }}', '_blank')"><button class="btn btn-info pink">Email All</button></a>
			<button type="button" id="checkTime" onclick="loadTime({{$class->classid}})" class="ascensorLink ascensorLink3 btn btn-info pink">View Timetable</button>
		</div>
</form>
</div>
</div>
<div id="class-students">
@foreach(json_decode($class->classstudents) as $student)
	<div class="col-sm-4" id="student{{ User::find($student)->id }}">
		<div class="feature-box">
			<div class="feature-text">
				<h3>Name: {{ User::find($student)->name }}</h3>
				<p>Student ID: {{ User::find($student)->username }}</p>
				<p>Major: {{ Departments::find(User::find($student)->department)->name() }}</p>
				<table border="0px">
				<tbody>
				<tr><td>
					<form class="removeStudent" action="" method="POST">
						<input type="hidden" id="classId" value="{{ $class->classid }}" />
						<input type="hidden" id="studentId" value="{{ User::find($student)->id }}" />
						<button type="submit" class="btn btn-info pink"><i class="fa fa-arrow-right"></i>Remove</button>
					</form>
				</td>
				<td>
					<a target="_blank" href="https://mail.google.com/mail?view=cm&tf=0%22+&to={{ User::find($student)->email }}">
						<button class="btn btn-info pink">Email</button>
					</a>
				</td></tr>
				</tbody>
				</table>
			</div>
		</div>
	</div>
@endforeach
</div>
