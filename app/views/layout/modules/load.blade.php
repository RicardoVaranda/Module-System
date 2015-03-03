@if(Session::has('global'))
	<div class="globalD arrowD">{{ Session::get('global') }}</div>
@endif
@include('layout.moduleedit', array('type' => 'new'))
@foreach(Modules::where('melective', 0)
		->where('departmentid', Auth::user()->department)
		->get() as $mod)
	@include('layout.moduleedit', array('mod' => $mod, 'type' => 'edit'))
@endforeach
{{ HTML::script('js/main.js') }}