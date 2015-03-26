<?php
class AccountController extends BaseController{

	public function getSignIn(){
		return View::make('account.signin');
	}

	public function postSignIn(){
		$validator = Validator::make(Input::all(),
			array(
				'username' => 'required',
				'password' => 'required'
				)
			);

		if($validator->fails()) {
			//Redirect to sign in page
			return Redirect::route('account-sign-in')
					->withErrors($validator)
					->withInput();
		} else {
			// Attempt user sign in

			$remember = (Input::has('remember')) ? true : false;

			$auth = Auth::attempt(array(
				'username' => Input::get('username'),
				'password' => Input::get('password'),
				'active' => 1
			), $remember);

			if($auth){
				//Redirect to the intended page
				return Redirect::intended('/')->with('global', 'Welcome back '.Auth::user()->name.'!');
			} else {
				return Redirect::route('account-sign-in')
						->with('global', 'Username or Password incorrect, or account not active.')->withInput();
			}
		}

		return Redirect::route('account-sign-in')
				->with('global', 'There was a problem signing you in.');
	}

	public function getSignOut(){
		Auth::logout();
		return Redirect::route('home');
	}

	public function getCreate(){
		return View::make('account.create');
	}

	// Note: Is name not required?
	public function postCreate(){
		$validator = Validator::make(Input::all(),
			array(
				'email' 			=> 'required|max:50|email|unique:users',
				'username' 			=> 'required|max:20|min:3|unique:users',
				'password'		 	=> 'required|min:6',
				'password_again' 	=> 'required|same:password'
			)
		);

		if($validator->fails()){
			return  Redirect::route('account-create')
					->withErrors($validator)
					->withInput();
		} else {
			
			$email = Input::get('email');
			$username = Input::get('username');
			$password = Input::get('password');

			// Activation code
			$code = str_random(60);

			// Note: Should rank not be defined?
			$user = User::create(array(
				'email' => $email,
				'username' => $username,
				'password' => Hash::make($password),
				'code' => $code,
				'active' => 0
			));

			if($user){

				Mail::send('emails.auth.activate', array('link' => URL::route('account-activate', $code), 'username' => $username), function($message) use ($user) {
					$message->to($user->email, $user->username)->subject('Activate your account');
				});

				return Redirect::route('home')
						->with('global', 'Your account has been created! We have sent you an email to activate your acount.');
			}
		}
	}

	public function getActivate($code){
		$user = User::where('code', '=', $code);

		if($user->count()){
			$user = $user -> first();

			//Update user active to 1 instead of 0
			$user->active 	= 1;
			$user->code 	= '';

			if($user->save()){
				return Redirect::route('home')
				->with('global', 'Activated! You can now sign in');
			}
		} 

		return Redirect::route('home')
				->with('global', 'We could not activate your account. Try again later.');
	}

	public function getChangePassword(){
		return Redirect::route('home', ['#changePass']);
	}

	public function postChangePassword(){
		$validator = Validator::make(Input::all(), 
			array(
				'old_password' 		=> 'required',
				'password' 			=> 'required|min:6',
				'password_again' 	=> 'required|same:password'
			));

		if($validator->fails()){
			return Redirect::route('home', ['#changePass'])
					->withErrors($validator)->with('pass', 'You password failed the validation');
		} else {

			$user = User::find(Auth::user()->id);

			$old_password 	= Input::get('old_password');
			$password 		= Input::get('password');

			if(Hash::check($old_password, $user->getAuthPassword())){
				//Password user provided  matches
				$user->password = Hash::make($password);

				if($user->save()){
					return Redirect::route('home')
					->with('global', 'Your password has been succesfully changed');
				}
			} else {
				return Redirect::route('home', ['#changePass'])
				->with('pass', 'Your old password is incorrect.');
			}

		}

		return Redirect::route('home', ['#changePass'])
				->with('pass', 'Your password could not be changed');
	}

	public function getForgotPassword(){
		return View::make('account.forgot');
	}

	public function postForgotPassword(){
		$validator = Validator::make(Input::all(), 
			array(
				'email' => 'required|email'
			)
		);

		if($validator->fails()){
			return Redirect::route('account-forgot-password')
				->withErrors($validator)
				->withInput();
		} else {

			$user = User::where('email', '=', Input::get('email'));

			if($user->count()) {
				$user = $user->first();

				//Generate a new random code and password
				$code 					= str_random(60);
				$password 				= str_random(10);

				$user->code 			= $code;
				$user->password_temp 	= Hash::make($password);

				// Verify that user information is updated correctly.
				if($user->save()){
					// Send email to user with new password and reset link.
					// Note: Changed username to name. Username in db is the id and it would look weird in email.
					Mail::send('emails.auth.forgot', array('link' => URL::route('account-recover', $code), 'username' => $user->name, 'password' => $password), function($message) use ($user){
						$message->to($user->email, $user->username)->subject('Your new password!');
					});

					return Redirect::route('home')
							->with('global', 'We have sent you a new password to your email.');
				}
			}
		}
		return Redirect::route('account-forgot-password')
				->with('global', 'Could not request new password');
	}

	public function getRecover($code){
		$user = User::where('code', '=', $code)
					->where('password_temp', '!=', '');

		if($user->count()) {
			$user = $user->first();

			$user->password = $user->password_temp;
			$user->password_temp = '';
			$user->code = '';
			if($user->save()){
				return Redirect::route('home')
						->with('global', 'Your account has been recovered and you can sign in with your new password.');
			}
		}

		return Redirect::route('home')
				->with('global', 'Could not recover your account.');

	}

	/**
	*	Function that creates new Lecturer and emails them with account info.
	*/
	public function createLecturer(){

		// Verify that input received is correct.
		$validator = Validator::make(Input::all(),
			array(
				'email' => 'required|max:50|email|unique:users',
				'username' 	=> 'required|max:20|min:3|unique:users',
				'name'	=> 'required'
			)
		);

		// Check that user is at least a HOD and that all validation is correct.
		if($validator->fails() || Auth::user()->rank < 2){
			// If not inform user of errors.
			return Response::json(array(
									'success' => false,
									'errors'  => $validator->messages()
									));
		} else {
			
			// Get lecturer info.
			$lecturerEmail = Input::get('email');
			$lecturerId = Input::get('username');
			$lecturerName = Input::get('name');

			// Generate activation code and password.
			$code = str_random(60);
			$password = str_random(10);

			// Create lecturer.
			$lecturer = User::create(array(
				'email'			=> $lecturerEmail,
				'username'		=> $lecturerId,
				'name'			=> $lecturerName,
				'rank'			=> 1,
				'department'	=> Auth::user()->department,
				'password'		=> Hash::make($password),
				'code'			=> $code,
				'active'		=> 0
			));

			// Verify that lecturer was created successfully.
			if($lecturer){

				// TODO: Laravel must be configured with a sender address before emails can be used.
				// Send email to lecturer with credentials and activation link.
				/*Mail::send('emails.auth.activateLecturer', array('link'		=> URL::route('account-activate', $code), 
																'name'		=> $lecturerName,
																'username'	=> $lecturerId,
																'password'	=> $password), 
																function($message) use ($lecturer) {
																		$message->to($lecturer->email, $lecturer->name)->subject('Account Created');
																}); */

				// Return successful response to user.
				return Response::json(array(
									'success'	=> true,
									'id'		=> $lecturer->id
									));
			}
		}
	}


	/**
	*	Function that creates new Lecturer and emails them with account info.
	*/
	public function removeLecturer(){

		// Load the lecturer to delete.
		$lecturer = User::find(Input::get('id'));

		// Verify that there are no classes under lecturer.
		$classes = Classes::where('classlecturer', Input::get('id'))->get();

		if(count($classes) > 0) {
			// Inform user that lecturer still has classes assigned.
			return Response::json(array(
							'success'	=> false,
							'errors'	=> 'Lecturer still has classes assigned!'
							));
		}

		// Delete lecturer.
		$lecturer->delete();
		
		// Return successful response to user.
		return Response::json(array(
							'success' => true
							));
	}

	/**
	*	Function that receives a CSV file, and creates
	*	users from it.
	*/
	public function uploadCSV(){

		// Get file uploaded by user.
		$CSV = $_FILES['usersCSV'];

		// Define user array for User creation.
		$user = array();
		$errors = array();
		$password = '';

		// Create variable to ensure we skip first row.
		$skipped = false;

		// Now open it so we can parse through it.
		if (($file = fopen($CSV['tmp_name'], "r")) !== false) {
			// Pass opened file to fgetcsv for parsing.
	    	while (($row = fgetcsv($file)) !== false) {
	    		// Check if we skipped.
	    		if ($skipped) {
		    		// Loop through all columns in current row.
	        		for ($column=0; $column < count($row); $column++) {
	            		switch($column) {
	            			case 0:
	            				$user['username'] = $row[$column];
	            			break;
	            			case 1:
	            				$user['name'] = $row[$column];
	            			break;
	            			case 2:
	            				$user['email'] = $row[$column];
	            			break;
	            			case 3:
	            				// Make copy of plaintext password in case we return error.
	            				$password = $row[$column];
	            				$user['password'] = Hash::make($row[$column]);
	            			break;
	            			case 4:
	            				$user['rank'] = $row[$column];
	            			break;
	            			case 5:
	            				$user['department'] = $row[$column];

	            				// This should be the last iteration so generate code.
	            				$code = str_random(60);
	            				$user['code'] = $code;

	            				// Verify that user id and email are unique.
	            				$unique = true;

	            				if(User::where('email', $user['email'])->count() > 0) {
	            					$unique = false;
	            				}

	            				if(User::where('username', $user['username'])->count() > 0) {
	            					$unique = false;
	            				}

	            				if($unique){
	            					// Create user.
	            					User::create($user);
	            				} else {
	            					// Reset password to plaintext.
	            					$user['password'] = $password;
	            					// Remove code.
	            					unset($user['code']);
	            					// Save to array to return for csv file.
	            					array_push($errors, $user);
	            				}
	            			break;
	            		}
	        		}
        		}
        		$skipped = true;
    		}
    		fclose($file);
		}

		// If we got errors return them.
		if(count($errors) > 0) {
			return Response::json(array(
								'success' => false,
								'filename' => $CSV['name'],
								'errors' => $errors
								));

		} else {
			// Return successful response to user.
			return Response::json(array(
								'success' => true
								));
		}
	}
}