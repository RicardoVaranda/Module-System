<?php

class ElectiveController extends BaseController {


	public function postRegisterElective() {
		// Quick fix to change form is class is full.
		$changeForm = false;

		$validator = Validator::make(Input::all(),
			array(
				'electiveId' => 'required'
				));

		if($validator->fails()) {

			// If not inform user of errors.
			return Response::json(array(
									'success' => false,
									'errors'  => $validator->messages()
									));
		} else {

			// Let's define what semester we are in.
			$today = date('Y-m-d');
			$semester = date('Y-m-d', strtotime(date('Y', strtotime($today)).'-06-01'));
			// If current date is greater than semester 2
			// Change current to semester 1.
			if($today > $semester) {
				// Get next year.
				$year = date('Y',strtotime(date("Y-m-d", time()) . " + 365 day"));
				$semester = date('Y-m-d', strtotime($year.'-01-01'));
			}

			$errors = '';

			// Get the user.
			$user = Auth::user();

			// Get the electives.
			$electives = $user->electives;

			// Check if they are null
			if($electives == null) {
				$electives = array();
				
			} else {

				$electives = json_decode($electives);

				// Verify that user hasn't already enrolled for elective.
				foreach($electives as $key => $value){
					if($value->electiveId == Input::get('electiveId')) {
						return Response::json(array('success' => false, 'errors' => 'You have already enrolled for this module!'));
					}
				}
			}

			// Get the elective Classes.
			$classes = Classes::where('classmodule', Input::get('electiveId'))->get();

			// Find an empty class.
			$class = null;
			foreach($classes as $c) {
				// Check if this class belongs to this year.
				if(date('Y', strtotime($c->created)) === date('Y', strtotime($today))) {
					// Now check that it is part of this semester.
					if(date('Y-m-d', strtotime($c->created)) < $semester) {
						if($c->classlimit > $c->classcurrent) {
							$class = $c;
						}
					}
				}
			}

			// Make sure we found an empty class
			if($class != null) {

				// Add user to class.
				$class->classcurrent = $class->classcurrent + 1;
				$students = $class->classstudents;
				if($students==""){
					$students = array();
				} else {
					$students = json_decode($students);
				}
				array_push($students, $user->id);
				// Normalize students array.
				$students = array_values($students);
				$class->classstudents = json_encode($students);
				$class->save();

				// Now add class to user.
				$elective = array('electiveId' => Input::get('electiveId'),
									'classId' => $class->classid,
									'date' => date('Y-m-d'));
				array_push($electives, $elective);
				$user->electives = json_encode($electives);
				$user->save();


			} else {

				// Inform user class is full.
				$errors = 'All classes are full!';
				$changeForm = true;
			}

			// Get the remaining spaces for elective.
			$classes = Classes::where('classmodule', Input::get('electiveId'))->get();
			$spaces = 0;
			foreach($classes as $c){
				// Check if this class belongs to this year.
				if(date('Y', strtotime($c->created)) === date('Y', strtotime($today))) {
					// Now check that it is part of this semester.
					if(date('Y-m-d', strtotime($c->created)) < $semester) {
						$spaces+=($c->classlimit-$c->classcurrent);
					}
				}
			}

			if($errors == '') {
				// Get Module info.
				$module = Modules::find(Input::get('electiveId'));
				// Get lecturer info.
				$lecturer = User::find($class->classlecturer);

				return Response::json(array(
										'success' => true,
										'spaces' => $spaces,
										'shorttitle' => $module->mshorttitle,
										'credits'	=> $module->mcredits,
										'lecturer' => $lecturer->name
									));
			}

			return Response::json(array(
										'success' => false,
										'spaces' => $spaces,
										'errors' => $errors,
										'change' => $changeForm
									));
		}
		
		}


		public function postUnregisterElective() {

			$validator = Validator::make(Input::all(),
				array(
					'electiveId' => 'required'
					));

			if($validator->fails()) {

				// If not inform user of errors.
				return Response::json(array(
										'success' => false,
										'errors'  => $validator->messages()
										));
			} else {
				//TODO: Verify that student registered to elective in current semester.

				$errors = '';

				// Get the user.
				$user = Auth::user();

				// Get the electives.
				$electives = $user->electives;

				$classId = '';

				// Check if they are null.
				if($electives == null) {
					return Response::json(array('success' => false, 'errors' => 'You are not enrolled to any modules!'));
					
				} else {
					$electives = json_decode($electives);

					// Remove the elective from user
					foreach($electives as $key => $value){
						if($value->electiveId == Input::get('electiveId')) {
							// Get classId and remove elective.
							$classId = $value->classId;
							unset($electives[$key]);
						}
					}
				}
				// Santize elective array.
				$temp = array();
				foreach($electives as $e) {
					array_push($temp, $e);
				}
				$electives = $temp;


				if($classId != '') {

					// Get the Class and it's students.
					$class = Classes::where('classId', $classId)->first();
					$students = json_decode($class->classstudents);
					$found = false;

					// Now remove student from class.
					foreach($students as $key => $value) {
						if($value == $user->id) {
							$found = true;
							unset($students[$key]);
						}
					}

					// Make sure we got a result before saving everything.
					if($found) {
						$class->classcurrent = $class->classcurrent - 1;
						// Normalize students array.
						$students = array_values($students);
						$class->classstudents = json_encode($students);
						$class->save();

						$user->electives = json_encode($electives);
						$user->save();
					} else {
						$errors = 'You are not registered in a class with this elective!';
					}
				} else {
					$errors = 'You are not registered to this elective!';
				}


				// Get the remaining spaces for elective.
				$classes = Classes::where('classmodule', Input::get('electiveId'))->get();
				$spaces = 0;
				foreach($classes as $c){
					$spaces+=($c->classlimit-$c->classcurrent);
				}

				if($errors == '') {
					return Response::json(array(
											'success' => true,
											'spaces' => $spaces
										));
				}

				return Response::json(array(
											'success' => false,
											'spaces' => $spaces,
											'errors' => $errors
										));
			}
		}

		public function postRequestElective() {

			$validator = Validator::make(Input::all(),
				array(
					'electiveId' => 'required'
					));

			if($validator->fails()) {

				// If not inform user of errors.
				return Response::json(array(
										'success' => false,
										'errors'  => $validator->messages()
										));
			} else {

				$errors = '';

				// Get the user.
				$user = Auth::user();

				// Get the module with that id.
				$module = Modules::where('mid', Input::get('electiveId'))->first();

				// Check if it's an elective.
				if(!$module->melective) {
					return Response::json(array('success' => false, 'errors' => 'There is no such elective.'));
					
				} else {
					// Extract that existing requests.
					$requests = ($module->mrequests == '') ? array() : json_decode($module->mrequests);

					// Check that the user hasn't already requested a class.
					foreach($requests as $request) {
						if($request == $user->id) {
							$errors = 'You have already requested this class!';
							return Response::json(array(
													'success' => false,
													'errors' => $errors
												));
						}
					}

					// Mark user has having made a request.
					array_push($requests, $user->id);
					$module->mrequests = json_encode($requests);
					$module->save();

					// Now check amount of users that have requested this class.
					if((count($requests) % 10) == 0) {
						// Email HOD to inform users want a new class.
						$department = $module->departmentid;
						$HOD = User::where('rank', 2)->where('department', $department)->first();
						Mail::send('emails.auth.request', array('name' => $name, 'requestCount' => count($requests), 'electiveName' => $module->mshorttitle), function($message) use ($HOD) {
							$message->to($HOD->email, $HOD->username)->subject('A new class has been requested');
						});

					}

					// Inform user request was made.
					return Response::json(array(
											'success' => true
										));
				}
			}
		}


		public function loadClass() {

			// Get the Class and it's students.
			$class = Classes::where('classId', Input::get('classId'))->first();
			$studentIds = json_decode($class->classstudents);
			$students = array();

			// Loop through all studentIds and get relevant info.
			foreach($studentIds as $s) {
				// Get current student.
				$user = User::find($s);

				// Save name and username.
				$name = $user->name;
				$username = $user->username;
				$email = $user->email;

				// Get the major.
				$major = Departments::find($user->department)->name();

				// Push to students array.
				array_push($students, array('id' => $s,
											'name' => $name,
											'username' => $username,
											'major' => $major,
											'email' => $email
											));
			}

			return Response::json(array(
										'success' => true,
										'limit' => $class->classlimit,
										'space' => ($class->classlimit - $class->classcurrent),
										'students' => $students
									));
		}

		public function updateClass() {
			$validator = Validator::make(Input::all(),
				array(
					'classId' => 'required',
					'limit' => 'required|numeric'
					));

			if($validator->fails()) {

				// If not inform user of errors.
				return Response::json(array(
										'success' => false,
										'errors'  => $validator->messages()
										));
			} else {

				// Get the Class to update.
				$class = Classes::where('classId', Input::get('classId'))->first();

				// Update the class.
				$class->classlimit = Input::get('limit');
				$class->save();

				return Response::json(array(
											'success' => true,
											'space' => ($class->classlimit - $class->classcurrent)
										));
			}
		}

		public function removeStudent() {

			$errors = '';

			// Get the Class to remove student from.
			$class = Classes::where('classId', Input::get('classId'))->first();

			// Get the student we are removing from class.
			$student = User::find(Input::get('studentId'));

			// Now get students electives, loop through them and remove class.
			$studentElectives = json_decode($student->electives);
			$found = false;

			foreach($studentElectives as $key => $value) {
				if($value->classId == Input::get('classId')) {
						// Remove class.
						unset($studentElectives[$key]);
						$found = true;
					}
			}

			// Let's make sure we found class in student's electives.
			if($found) {
				// Save student.
				$student->electives = json_encode($studentElectives);
				$student->save();

				// Now loop through class students and remove student.
				$classStudents = json_decode($class->classstudents);

				foreach($classStudents as $key => $value) {
					if($value == Input::get('studentId')) {
						// Remove student.
						unset($classStudents[$key]);
					}
				}

				// Normalize classStudents array.
				$classStudents = array_values($classStudents);

				$class->classstudents = json_encode($classStudents);

				// Decrement classcurrent.
				$class->classcurrent = $class->classcurrent - 1;

				// Save class.
				$class->save();
			} else {
				$errors = 'Student has already been removed from class!';
			}

			// Verify there was no error.
			if($errors == '') {
				return Response::json(array(
										'success' => true,
										'space' => ($class->classlimit - $class->classcurrent)
									));
			} else {
				return Response::json(array(
										'success' => false,
										'errors' => $errors
									));
			}
		}


	public function postElectiveNew(){

		$inputData = Input::get('elecData');
	    parse_str($inputData, $formFields);  
	    $moduleData = array(
	      'classlecturer'      => $formFields['classlecturer'],
	      'classmodule'		=> $formFields['classmodule'],
	      'classlimit'     =>  $formFields['classlimit'],
	    ); 

	    Validator::extend('ranked', function($attribute, $value, $parameters)
		{
			// This is the correct way to do this.
			$coord = User::where('name', $value)->first();
			if($coord && $coord->rank < 1){
				return false;
			}
		   
		  return true;
		});

        Validator::extend('indep', function($attribute, $value, $parameters)
    {
      // This is the correct way to do this.
      $mod = Modules::find($value);
      if($mod && $mod->departmentid !== Auth::user()->department){
        return false;
      }
       
      return true;
    });

	    $rules = array(
			'classmodule'	=> 'required|exists:modules,mid|indep',
			'classlecturer' 	=> 'required|exists:users,name|ranked',
			'classlimit'	 	=> 'required|integer|between:5,30',
		);
		
		$messages = [
		    'ranked' => "This user can't coordinate this class.",
		    'indep'  => "This module is not in your department.",
		];

		$validator = Validator::make($moduleData,$rules,$messages);

		if($validator->fails()){
	        return Response::json(array(
	            'fail' => true,
	            'errors' => $validator->getMessageBag()->toArray()
	        ));
	    } else {
		$moduleData['classlecturer'] = User::where('name', $moduleData['classlecturer'])->first()->id;
	    	if(Classes::create($moduleData)){
	    		Session::flash('global', 'You have created an elective.');
	    		  //return success  message
		        return Response::json(array(
		          'success' => true,
		          'mName' => Modules::find($moduleData['classmodule'])->mshorttitle 
		        ));
	    	}
		}
	}

	public function postElectiveChange(){

		$inputData = Input::get('elecData');
	    parse_str($inputData, $formFields);  
	    $moduleData = array(
	      'classlecturer'      => $formFields['classlecturer'],
	      'classmodule'		=> $formFields['classmodule'],
	      'classlimit'     =>  $formFields['classlimit'],
	    ); 

	    Validator::extend('ranked', function($attribute, $value, $parameters)
		{
			// This is the correct way to do this.
			$coord = User::where('name', $value)->first();
                        if($coord && $coord->rank < 1){
                                return false;
                        }
		   
		  return true;
		});

        Validator::extend('indep', function($attribute, $value, $parameters)
    {
      // This is the correct way to do this.
      $mod = Modules::find($value);
      if($mod && $mod->departmentid !== Auth::user()->department){
        return false;
      }

      return true;
    });


	    $rules = array(
			'classmodule'	=> 'required|exists:modules,mid|indep',
			'classlecturer' 	=> 'required|exists:users,name|ranked',
			'classlimit'	 	=> 'required|integer|between:5,30',
		);

		$messages = [
		    'ranked' => "This user can't coordinate this class.",
                    'indep'  => "This module is not in your department.",

		];

		$validator = Validator::make($moduleData,$rules,$messages);
		

		if($validator->fails()){
	        return Response::json(array(
	            'fail' => true,
	            'errors' => $validator->getMessageBag()->toArray()
	        ));
	    } else {

	    	$elec = Classes::where('classid', $formFields['classid'])->first();

	    	$elec->classmodule = $moduleData['classmodule'];
	    	$elec->classlecturer = User::where('name', $moduleData['classlecturer'])->first()->id;
	    	$elec->classlimit = $moduleData['classlimit'];
	    	
	    	if($elec->save()){
	    		Session::flash('global', 'You have edited a module.');
	    		  //return success  message
		        return Response::json(array(
		          'success' => true,
		          'mName' => Modules::find($moduleData['classmodule'])->mshorttitle
		        ));
	    	}
		}
	}



	public function getElectives(){
		if(Auth::check()){
			if (Auth::user()->rank >= 2) 
				return View::make('layout.electives.hodload');	
			else
				return View::make('layout.electives.student');
		}
		else
		{
			return Redirect::route('account-sign-in');
		}
	}

	function printClassList($classId) {
	    if(Classes::where('classid', $classId)->count()){
	    	$class = Classes::where('classid', $classId)->first();

	    	if($class->classlecturer != Auth::user()->id){
	    		return;
	    	}

		    $filename = Modules::where('mid', $class->classmodule)->first()->mcode."Elec".$classId."List.csv";
			$delimiter=",";
		    header('Content-Type: application/csv');
		    header('Content-Disposition: attachement; filename="'.$filename.'";');

	    	$array = array();
	    	array_push($array, array('Student ID' => 'Student ID','Name' => 'Student Name'));

	    	foreach(json_decode($class->classstudents) as $student){
	    		$studentarray = array('Student Id' => User::find($student)->username,
			           'Name' => User::find($student)->name);
			    array_push($array, $studentarray);
	    	}

	    	$f = fopen('php://output', 'w');

		    foreach ($array as $line) {
		        fputcsv($f, $line, $delimiter);
		    }
	    }
	}

}
?>
