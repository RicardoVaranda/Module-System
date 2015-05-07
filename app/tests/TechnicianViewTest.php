<?php

class TechnicianViewTest extends TestCase {
	
	// Define user login credentials.
	private $username = 'technician';
	private $password = 'password';

	public function testController() {
		// Log in so we have an authenticated user.
		$crawler = $this->client->request('POST', '/account/signin', ['username' => $this->username, 'password' => $this->password]);
		$this->assertRedirectedTo('/');

		// Create a module to test with.
		$d = array('mname' => 'name123',
					'mshorttitle' => 'short123',
					'mdescription' => str_random(60),
					'mcode' => 'abc1234',
					'mfieldofstudy' => 'abc123',
					'mcoordinator' => 'lecturer',
					'mlevel' => 'Fundamental',
					'mcredits' => 5,
					'melective'	=> true);
		$module = $this->createModule($d, true);

		// Try to create a module with incorrect syntax.
		$d = array('mname' => 'name123',
					'mshorttitle' => 'short123',
					'mdescription' => str_random(60),
					'mcode' => 'abc1234',
					'mfieldofstudy' => 'abc123',
					'mcoordinator' => 'lecturer',
					'mlevel' => 'Fundamental',
					'mcredits' => 'five',
					'melective'	=> true);
		$this->createModule($d, false);


		// Update the module.
		$d = array('mname' => 'name12345',
					'mshorttitle' => 'short123',
					'mdescription' => str_random(60),
					'mcode' => 'abc1234',
					'mfieldofstudy' => 'abc123',
					'mcoordinator' => 'lecturer',
					'mlevel' => 'Fundamental',
					'mcredits' => 5,
					'melective'	=> true,
					'mid' => $module->mid);
		$module = $this->updateModule($module->mid, $d, true);

		// Try to update the module with incorrect syntax.
		$d = array('mname' => 'name12345',
					'mshorttitle' => 'short123',
					'mdescription' => str_random(60),
					'mcode' => 'abc1234',
					'mfieldofstudy' => 'abc123',
					'mcoordinator' => 'lecturer',
					'mlevel' => 'Fundamental',
					'mcredits' => 'five',
					'melective'	=> true,
					'mid' => $module->mid);
		$this->updateModule($module->mid, $d, false);

		// Now create an elective of that module.
		$d = array('classlecturer' => 'lecturer',
					'classmodule' => $module->mid,
					'classlimit' => 10);
		$elective = $this->createElective($module->mid, $d, true);

		// Now try creating an elective with incorrect syntax.
		$d = array('classlecturer' => 'lecturer',
					'classmodule' => $module->mid,
					'classlimit' => 'ten');
		$this->createElective($module->mid, $d, false);

		// Now update an elective.
		$d = array('classlecturer' => 'lecturer',
					'classmodule' => $module->mid,
					'classlimit' => 10,
					'classid' => $elective->classid);
		$elective = $this->updateElective($elective->classid, $d, true);

		// Try to update elective with bad syntax.
		$d = array('classlecturer' => 'lecturer',
					'classmodule' => $module->mid,
					'classlimit' => 'ten',
					'classid' => $elective->classid);
		$this->updateElective($elective->classid, $d, false);

		// Create test faculty.
		$faculty = $this->createFaculty(true);

		// Create faculty with bad syntax.
		$this->createFaculty(false);

		// Update the faculty.
		$faculty = $this->updateFaculty($faculty->facultyid);

		// Create test department.
		$department = $this->createDepartment(true);

		// Try creating test department with incorrect syntax.
		$this->createDepartment(false);

		// Update the department.
		$department = $this->updateDepartment($department->departmentid, true);

		// Try updating department with incorrect syntax.
		$this->updateDepartment($department->departmentid, false);

		// Delete dummy data.
		$elective->delete();
		$module->delete();
		$faculty->delete();
		$department->delete();

	}

	/** 
	 * Function that creates a module
	 */
	protected function createModule($d, $expected) {
		$data = '';
		foreach($d as $key => $value) {
			$data = $data.$key.'='.$value.'&';
		}
		$response = $this->call('POST', '/module-new', ['modData' => $data]);

		$json = json_decode($response->getContent());
		if($expected) {
			$this->assertEquals(true, $json->success);

			// Return the module we just created.
			return Modules::where('mfulltitle', $json->mName)->first();
		} else {
			$this->assertEquals(true, $json->fail);
		}
	}

	/** 
	 * Function that updates a module
	 */
	protected function updateModule($mid, $d, $expected) {
		$data = '';
		foreach($d as $key => $value) {
			$data = $data.$key.'='.$value.'&';
		}
		$response = $this->call('POST', '/module-change', ['modData' => $data]);

		$json = json_decode($response->getContent());
		if($expected) {
			$this->assertEquals(true, $json->success);

			// Get the module we just updated.
			$m = Modules::where('mid', $mid)->first();

			// Verify that the change was made.
			$this->assertEquals('name12345', $m->mfulltitle);

			// Now return the module.
			return $m;
		} else {
			$this->assertEquals(true, $json->fail);
		}
	}

	/** 
	 * Function that creates a Faculty.
	 */
	protected function createFaculty() {
		$response = $this->call('POST', '/account/create-faculty', ['name' => 'phpunitFaculty',
															'shortname' => 'phpunitFaculty',
															'description' => str_random(60)]);

		$json = json_decode($response->getContent());
		$this->assertEquals(true, $json->success);

		// Return the faculty we just created.
		return Faculty::find($json->facultyId);
	}

	/** 
	 * Function that updates specified faculty.
	 */
	protected function updateFaculty($id) {
		$response = $this->call('POST', '/account/update-faculty', ['name' => 'phpunitFaculty123',
																'shortname' => 'phpunitFaculty',
																'description' => str_random(60),
																'id' => $id]);

		$json = json_decode($response->getContent());
		$this->assertEquals(true, $json->success);

		// Verify that the change was made.
		$f = Faculty::find($id);
		$this->assertEquals('phpunitFaculty123', $f->facultyname);

		return $f;		
	}

	/** 
	 * Function that creates a Department.
	 */
	protected function createDepartment($expected) {
		if($expected) {
			$response = $this->call('POST', '/account/create-department', ['name' => 'phpunitDepartment',
																'shortname' => 'phpunitDepartment',
																'head'	=> 'headofdepartment',
																'description' => str_random(60),
																'facultyId'	=> 1]);

			$json = json_decode($response->getContent());
			$this->assertEquals($expected, $json->success);

			// Return the  we just created.
			return Departments::find($json->departmentId);
		} else {
			$response = $this->call('POST', '/account/create-department', ['name' => 'phpunitDepartment',
																'shortname' => 'phpunitDepartment',
																'head'	=> 'headofdepartment',
																'description' => str_random(30),
																'facultyId'	=> 'one']);

			$json = json_decode($response->getContent());
			$this->assertEquals($expected, $json->success);
		}
	}

	/** 
	 * Function that updates specified department.
	 */
	protected function updateDepartment($id, $expected) {
		if($expected) {
			$response = $this->call('POST', '/account/update-department', ['name' => 'phpunitDepartment123',
																	'shortname' => 'phpunitDepartment',
																	'head'	=> 'headofdepartment',
																	'description' => str_random(60),
																	'facultyId' => 1,
																	'id'	=> $id]);

			$json = json_decode($response->getContent());
			$this->assertEquals(true, $json->success);

			// Verify that the change was made.
			$d = Departments::find($id);
			$this->assertEquals('phpunitDepartment123', $d->departmentname);

			return $d;
		} else {
			$response = $this->call('POST', '/account/update-department', ['name' => 'phpunitDepartment123',
																	'shortname' => 'phpunitDepartment',
																	'head'	=> 'headofdepartment',
																	'description' => str_random(60),
																	'facultyId' => 'one',
																	'id'	=> $id]);

			$json = json_decode($response->getContent());
			$this->assertEquals(false, $json->success);
		}
	}

	/** 
	 * Function that creates an elective for a specified module.
	 */
	protected function createElective($mid, $d, $expected) {
		$data = '';
		foreach($d as $key => $value) {
			$data = $data.$key.'='.$value.'&';
		}
		// TODO: Once elective creation is resolved change path below.
		$response = $this->call('POST', '/elective-new', ['elecData' => $data]);

		$json = json_decode($response->getContent());
		if($expected) {
			$this->assertEquals(true, $json->success);

			// Return the Class we just created.
			return Classes::where('classmodule', $mid)->first();
		} else {
			$this->assertEquals(true, $json->fail);
		}
	}

	/** 
	 * Function that updates a module
	 */
	protected function updateElective($id, $d, $expected) {
		$data = '';
		foreach($d as $key => $value) {
			$data = $data.$key.'='.$value.'&';
		}
		$response = $this->call('POST', '/elective-change', ['elecData' => $data]);

		$json = json_decode($response->getContent());
		if($expected) {
			$this->assertEquals(true, $json->success);

			// Get the module we just updated.
			$c = Classes::where('classid', $id)->first();

			// Now return the class.
			return $c;
		} else {
			$this->assertEquals(true, $json->fail);
		}
	}
}

