@foreach(Classes::all() as $elec)
	@include('layout.electivepreview', array('elec' => $elec))
@endforeach