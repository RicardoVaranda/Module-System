@if(Session::has('global'))
	<div class="globalD arrowD">{{ Session::get('global') }}</div>
@endif
@include('layout.electives.hod', array('type' => 'new'))
@foreach(Classes::all() as $elec)
<?php $mod = Modules::find($elec->classmodule); ?>
	@if ($mod->departmentid ==  Auth::user()->department)
		@include('layout.electives.hod', array('elec' => $elec, 'type' => 'edit'))
	@endif
@endforeach