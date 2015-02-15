@if(!Auth::check())
	{{Redirect::route('account-sign-in')}}
@else
	@include('layout.main')
@endif