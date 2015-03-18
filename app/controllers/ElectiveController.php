<?php

class ElectiveController extends BaseController {


	public function postRegisterElective() {

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
				if($c->classlimit > $c->classcurrent) {
					$class = $c;
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


		public function postUnregisterElective() {
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

				// Get the major.
				$major = Departments::find($user->department)->name();

				// Push to students array.
				array_push($students, array('id' => $s,
											'name' => $name,
											'username' => $username,
											'major' => $major
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



	// RIC -> ERRORS INBOUND :D

	public function postElectiveNew(){

		$inputData = Input::get('elecData');
	    parse_str($inputData, $formFields);  
	    $elecData = array(
	      'classlecturer'	=> $formFields['clect'],
	      'classmodule'		=> $formFields['cmod'],
	      'classlimit'		=> $formFields['climit'],
	      //'classtimes'				=> $formFields[''],
	    ); 

	    Validator::extend('ranked', function($attribute, $value, $parameters)
		{
			$coord = User::where('name', $value)->first();
			if($coord->rank < 1){
				return false;
			}
		   
		  return false;
		});

	    $rules = array(
			'classlecturer' => 'required|max:50|exists:users,name|ranked',
			'classmodule'	=> 'required|exists:modules,mshorttitle',
			'classlimit'	=> 'required|min:10|max:30',
			//'classtimes'	=> 'required|',
		);
			
		$messages = [
		    'ranked' => "This user can't coordinate this class.",
		];

		$validator = Validator::make($elecData,$rules,$messages);

		if($validator->fails()){
	        return Response::json(array(
	            'fail' => true,
	            'errors' => $validator->getMessageBag()->toArray()
	        ));
	    } else {

	    	if(Classes::create($elecData)){
	    		Session::flash('global', 'You have created the elective "'. $elecData['classmodule'].'".');
	    		  //return success  message
		        return Response::json(array(
		          'success' => true,
		          'mName' => $elecData['classmodule']
		        ));
	    	}
		}
	}

	public function postElectiveChange(){

		$inputData = Input::get('elecData');
	    parse_str($inputData, $formFields);  
	    $elecData = array(
	      'mfulltitle'      => $formFields['mname'],
	      //add the rest
	    );

	    Validator::extend('ranked', function($attribute, $value, $parameters)
		{
			$coord = User::where('name', $value)->first();
			if($coord->rank < 1){
				return false;
			}
		   
		  return false;
		});

	    $rules = array(
			'mfulltitle' 	=> 'required|max:50|unique:modules,mfulltitle,'.$formFields['mcode'].',mcode',
			'mshorttitle'	=> 'required|max:50|unique:modules,mshorttitle,'.$formFields['mcode'].',mcode',
			'mdescription'	=> 'required|min:30',
			'mcode'		 	=> 'required|min:7|max:8|alpha_num|unique:modules,mcode,'.$formFields['mcode'].',mcode',
			'mfieldofstudy'	=> 'required|max:100',
			'mcoordinator' 	=> 'required|exists:users,name|ranked',
			'mlevel' 		=> 'required|in:Fundamental,Intermediate,Advanced,Expert',
			'mcredits'	 	=> 'required|integer|between:5,25',
			'mid'			=> 'required|exists:modules,mid',
			'departmentid'	=> 'required',
		);

		$messages = [
		    'ranked' => "This user can't coordinate this class.",
		];

		$validator = Validator::make($moduleData,$rules,$messages);
		

		if($validator->fails()){
	        return Response::json(array(
	            'fail' => true,
	            'errors' => $validator->getMessageBag()->toArray()
	        ));
	    } else {

	    	$mod = Modules::where('mid', $moduleData['mid'])->first();

	    	$mod->mfulltitle = $moduleData['mfulltitle'];
	    	$mod->mshorttitle = $moduleData['mshorttitle'];
	    	$mod->mdescription = $moduleData['mdescription'];
	    	$mod->mcode = $moduleData['mcode'];
	    	$mod->mfieldofstudy = $moduleData['mfieldofstudy'];
	    	$mod->mcoordinator = $moduleData['mcoordinator'];
	    	$mod->mlevel = $moduleData['mlevel'];
	    	$mod->mcredits = $moduleData['mcredits'];
	    	$mod->departmentid = $moduleData['departmentid'];
	    	
	    	if($mod->save()){
	    		Session::flash('global', 'You have edited the module "'. $moduleData['mfulltitle'].'".');
	    		  //return success  message
		        return Response::json(array(
		          'success' => true,
		          'mName' => $moduleData['mfulltitle']
		        ));
	    	}
		}
	}

	public function getElectives(){
		if(Auth::check()){
			if (Auth::user()->rank >= 2) 
				return View::make('layout.electives.hodload') ;
			else
				return;
		}
		else
		{
			return Redirect::route('account-sign-in');
		}
	}
 
}
?>