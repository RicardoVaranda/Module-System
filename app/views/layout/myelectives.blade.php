<div class="col-sm-6 col-md-4">
	<div class="feature-box">
		<div class="feature-icon"><i class="fa fa-twitter"></i></div>
		<div class="feature-text">
			<?php $mod = Modules::where('mid', $elec->electiveId)->first(); ?>
			<h3>{{$mod->mshorttitle}}</h3>
			<small style="float:right"><u>{{$mod->mcredits}} Credits</u></small>
			<p>{{User::find(Classes::find($elec->classId)->classlecturer)->name}}</p>
			</br>
		</div>
		<button type="button" class="pull-left btn-elec btn-primary"><i class="fa fa-arrow-right"></i>remove elective</button>
	<button type="button" class="pull-right btn-elec btn-primary"><i class="fa fa-arrow-right"></i>check timetable</button>

	</div>
</div>