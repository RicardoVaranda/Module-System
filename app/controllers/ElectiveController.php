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
?>