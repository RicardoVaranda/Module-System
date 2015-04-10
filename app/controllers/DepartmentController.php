<?php

class DepartmentController extends BaseController {

	public function createDepartment() {

		$validator = Validator::make(Input::all(),
			array(
				'name' => 'required',
				'shortname' => 'required',
				'head' => 'required',
				'description' => 'required',
				'facultyId' => 'required'
				));

		if($validator->fails()) {

			// If not inform user of errors.
			return Response::json(array(
									'success' => false,
									'errors'  => $validator->messages()
									));
		} else {
			// Check user has permission to create department.
			if(Auth::user()->rank == 3) {

				// Now just create Department.
				$department = Departments::create(array('departmentname' => Input::get('name'),
									'departmentshort' => Input::get('shortname'),
									'departmenthead' => Input::get('head'),
									'departmentdescription' => Input::get('description'),
									'facultyid' => Input::get('facultyId')));

				// Get faculty list so we can return with response.
				$faculties = Faculty::all();

				// If not inform user of errors.
				return Response::json(array(
									'success' => true,
									'departmentId'  => $department->departmentid,
									'faculties' => $faculties
									));
			}
		}
	}

	public function updateDepartment() {

		$validator = Validator::make(Input::all(),
			array(
				'name' => 'required',
				'id'	=> 'required',
				'shortname' => 'required',
				'head'	=>	'required',
				'description' => 'required',
				'facultyId'	=> 'required'
				));

		if($validator->fails()) {

			// If not inform user of errors.
			return Response::json(array(
									'success' => false,
									'errors'  => $validator->messages()
									));
		} else {
			// Check user has permission to create department.
			if(Auth::user()->rank == 3) {
				// Load the Department.
				$department = Departments::find(Input::get('id'));

				// Save changes.
				$department->departmentname = Input::get('name');
				$department->departmentshort = Input::get('shortname');
				$department->departmenthead = Input::get('head');
				$department->departmentdescription = Input::get('description');
				$department->facultyid = Input::get('facultyId');
				$department->save();


				// If not inform user of errors.
				return Response::json(array(
									'success' => true
									));
			}
		}
	}

}
?>