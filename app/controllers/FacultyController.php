<?php

class FacultyController extends BaseController {

	public function createFaculty() {

		$validator = Validator::make(Input::all(),
			array(
				'name' => 'required',
				'shortname' => 'required',
				'description' => 'required'
				));

		if($validator->fails()) {

			// If not inform user of errors.
			return Response::json(array(
									'success' => false,
									'errors'  => $validator->messages()
									));
		} else {
			// Check user has permission to create faculty.
			if(Auth::user()->rank == 3) {

				// Now just create Faculty.
				$faculty = Faculty::create(array('facultyname' => Input::get('name'),
									'facultyshort' => Input::get('shortname'),
									'facultydescription' => Input::get('description')));

				// If not inform user of errors.
				return Response::json(array(
									'success' => true,
									'facultyId'  => $faculty->facultyid
									));
			}
		}
	}

	public function updateFaculty() {

		$validator = Validator::make(Input::all(),
			array(
				'name' => 'required',
				'shortname' => 'required',
				'description' => 'required'
				));

		if($validator->fails()) {

			// If not inform user of errors.
			return Response::json(array(
									'success' => false,
									'errors'  => $validator->messages()
									));
		} else {
			// Check user has permission to create faculty.
			if(Auth::user()->rank == 3) {
				// Load the Faculty.
				$faculty = Faculty::find(Input::get('id'));

				// Save changes.
				$faculty->facultyname = Input::get('name');
				$faculty->facultyshort = Input::get('shortname');
				$faculty->facultydescription = Input::get('description');
				$faculty->save();


				// If not inform user of errors.
				return Response::json(array(
									'success' => true
									));
			}
		}
	}

}
?>