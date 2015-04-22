<div class="col-sm-6 col-md-4 myclass{{ $elec->electiveId }}">
	<div class="feature-box">
		<div class="feature-icon"><i class="fa fa-twitter"></i></div>
		<div class="feature-text">
			<?php $mod = Modules::where('mid', $elec->electiveId)->first(); ?>
			<h3>{{$mod->mshorttitle}}</h3>
			<small style="float:right"><u>{{$mod->mcredits}} Credits</u></small>
			<p>{{User::find(Classes::find($elec->classId)->classlecturer)->name}}</p>
			</br>
		</div>
		<form class="electiveUnregister">
			<input type="hidden" id="electiveId" value="{{ $mod->mid }}" /> 
			<button type="submit" class="pull-left btn-elec btn-primary"><i class="fa fa-arrow-right"></i>remove elective</button>
		</form>
	<button type="button" id="checkTime" onclick="loadTime({{$elec->classId}})" class="ascensorLink ascensorLink3 pull-right btn-elec btn-primary"><i class="fa fa-arrow-right"></i>check timetable</button>

	</div>
</div>