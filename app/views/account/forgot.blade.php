@extends('account.loginTemplate')

@section('content')
	<h1>Forgot Password</h1>
	<h4>Enter email to recover your password</h4>
	<form style="background:none" action="{{ URL::route('account-forgot-password-post') }}" method="post">
		<div style="color:white">
			Email: <input type="text" name="email" {{ (Input::old('email')) ? 'value ="'. e(Input::old('email')) . '"' : '' }}>	
		<input type="submit" value="Recover"><br />
		@if($errors->has('email'))
				{{ $errors->first('email') }}
		@endif
		</div>
		{{ Form::token() }}
	</form><br /><br />
	<a href="signin"><button><< Back</button></a>	
@stop

