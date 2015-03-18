@if(Session::has('global'))
	<div class="globalD arrowD">{{ Session::get('global') }}</div>
@endif
@include('layout.electives.hod', array('type' => 'new'))
@foreach(Modules::where('departmentid', Auth::user()->department)
		->get() as $mod)
@foreach(Classes::where('classmodule', $mod->mid)->get() as $elec)
	@include('layout.electives.hod', array('elec' => $elec, 'type' => 'edit'))
@endforeach
@endforeach
{{ HTML::script('js/main.js') }}