@extends('account.loginTemplate')

@section('content')
<h1>
<span id="user" ContentEditable="false" style="text-transform:uppercase">{{ (Input::old('username')) ? e(Input::old('username')) : '[Student ID]' }}</span>
<span id="notyou">(not you?)</span>
</h1>
<h4>CIT Module System</h4>
<form id="loginForm"autocomplete=false action="{{ URL::route('account-sign-in-post') }}" method="POST">
<input id="username" name="username" style="display:none;" {{ (Input::old('username')) ? ' value="'. e(Input::old('username')) . '"' : '' }} required>
<input id="pass" name="password" type="password" text="" placeholder="Password" required>
<div id="showPass"></div>
<div id="submit"></div>
{{ Form::token()}}
</form>
<input type="checkbox" name="remember" id="remember">
<label for="remember" id="remember">
	Remember me
</label>
<a href="forgot"><button class="forgotPass" >Forgot Password?</button></a>
@stop