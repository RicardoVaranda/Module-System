<?php
class ProfileController extends BaseController{
	public function user($username){
		$user = User::where('username', '=', $username);

		if($user->count()) {
			$user = $user->first();

			return View::make('profile.user')
					->with('user', $user);
		}

		returnApp::abort(404);
	}
}