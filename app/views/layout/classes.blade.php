<label>Select Class:</label>
<select id="class-Select" class="form-control">
	@foreach(Classes::where('classlecturer', Auth::user()->id)->get() as $class)
		<?php $elective = Modules::where('mid', $class->classmodule)->first(); ?>
		<option value="{{ $class->classid }}">{{ $elective->mshorttitle }}</option>
	@endforeach
</select>
<br>
<form action="" method="POST" id="classForm">
	<?php $class = Classes::where('classlecturer', Auth::user()->id)->first(); ?>
	<label>Space Limit:</label><input type="text" class="form-control" id="classlimit" placeholder="Class Space Limit" value="{{ $class->classlimit }}" />
	<label>Space Left:</label><input type="text" class="form-control" id="classleft" placeholder="Space Left in Class" value="{{ ($class->classlimit - $class->classcurrent) }}" disabled/>
	<input type="hidden" id="classId" value="{{ $class->classid }}"/>
	<button type="submit" class="btn btn-primary" style="margin-top: 10px;">Update Class</button>
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
				<form class="removeStudent" action="" method="POST">
					<input type="hidden" id="classId" value="{{ $class->classid }}" />
					<input type="hidden" id="studentId" value="{{ User::find($student)->id }}" />
					<button type="submit" class="btn btn-primary"><i class="fa fa-arrow-right"></i>Remove</button>
				</form>
			</div>
		</div>
	</div>
@endforeach
</div>