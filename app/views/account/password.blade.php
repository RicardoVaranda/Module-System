<form action ="{{ URL::route('account-change-password-post') }}" method="post">
		<div class="field">
			Old password: <input type="password" name="old_password">
			@if ($errors->has('old_password'))
				{{ $errors->first('old_password') }}
			@endif
		</div>
		<div class="field">
			New password: <input type = "password" name="password">
			@if ($errors->has('password'))
				{{ $errors->first('password') }}
			@endif
		</div>
		<div class="field">
			
		</div>
</form>