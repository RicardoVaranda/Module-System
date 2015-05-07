<div class="modal fade" id="contact" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div  class="contact-box">
        	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <form name="contactform" id="contactform" action="{{ URL::route('account-change-password-post') }}" method="post">
                <fieldset>
                    <h4 class="h4">Change Your Password</h4>
                    <div class="form-group">
                        <i class="fa fa-unlock"></i>
                        <input type="password" name="old_password" id="pass" class="form-control" placeholder="Old Password (required)" required>
								@if ($errors->has('old_password'))
								{{ $errors->first('old_password') }}
							@endif
                    </div>
                    <div class="form-group">
                        <i class="fa fa-key"></i>
                        <input type="password" name="password" id="npassword" class="form-control" placeholder="New Password (required)" required>
                            @if ($errors->has('password'))
								{{ $errors->first('password') }}
							@endif
                    </div>
                    <div class="form-group">
                        <i class="fa fa-key"></i>
                		<input type="password" name="password_again" id="passagain" class="form-control" placeholder="Password Again (required)" required>
     		                @if ($errors->has('password_again'))
								{{ $errors->first('password_again') }}
							@endif
		                </div>
                    <div class="form-group">
                        <i class="fa fa-arrow-right"></i>
                        <button type="submit" id="submit" class="btn btn-info btn-block">Change Password</button>
                		{{Form::token()}}
                    </div>
                </fieldset>
            </form>
            <div id="state-message"></div>
		</div>
	</div>
</div>
