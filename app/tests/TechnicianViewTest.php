<?php

class TechnicianViewTest extends TestCase {
	
	// Define user login credentials.
	private $username = 'technician';
	private $password = 'abc123';

	public function testController() {
		// Log in so we have an authenticated user.
		$crawler = $this->client->request('POST', '/account/signin', ['username' => $this->username, 'password' => $this->password]);
		$this->assertRedirectedTo('/');

		// Create a module to test with.
		$module = $this->createModule();

		// Update the module.
		$module = $this->updateModule($module->mid);

		// Now create an elective of that module.
		//$elective = $this->createElective($module->mid);

		// Now update an elective.
		//$elective = $this->updateElective($elective->classid);

		// Create test faculty.
		$faculty = $this->createFaculty();

		// Update the faculty.
		$faculty = $this->updateFaculty($faculty->facultyid);

		// Create test department.
		$department = $this->createDepartment();

		// Update the department.
		$department = $this->updateDepartment($department->departmentid);

		// Delete dummy data.
		$module->delete();
		//$elective->delete();
		$faculty->delete();
		$department->delete();

	}

	/** 
	 * Function that creates a module
	 */
	protected function createModule() {
		$data = '';
		$d = array('mname' => 'name123',
					'mshorttitle' => 'short123',
					'mdescription' => str_random(60),
					'mcode' => 'abc1234',
					'mfieldofstudy' => 'abc123',
					'mcoordinator' => 'lecturer',
					'mlevel' => 'Fundamental',
					'mcredits' => 5,
					'melective'	=> true);
		foreach($d as $key => $value) {
			$data = $data.$key.'='.$value.'&';
		}
		$response = $this->call('POST', '/module-new', ['modData' => $data]);

		$json = json_decode($response->getContent());
		$this->assertEquals(true, $json->success);

		// Return the module we just created.
		return Modules::where('mfulltitle', $json->mName)->first();
	}

	/** 
	 * Function that updates a module
	 */
	protected function updateModule($mid) {
		$data = '';
		$d = array('mname' => 'name12345',
					'mshorttitle' => 'short123',
					'mdescription' => str_random(60),
					'mcode' => 'abc1234',
					'mfieldofstudy' => 'abc123',
					'mcoordinator' => 'lecturer',
					'mlevel' => 'Fundamental',
					'mcredits' => 5,
					'melective'	=> true,
					'mid' => $mid);
		foreach($d as $key => $value) {
			$data = $data.$key.'='.$value.'&';
		}
		$response = $this->call('POST', '/module-change', ['modData' => $data]);

		$json = json_decode($response->getContent());
		$this->assertEquals(true, $json->success);

		// Get the module we just updated.
		$m = Modules::where('mid', $mid)->first();

		// Verify that the change was made.
		$this->assertEquals('name12345', $m->mfulltitle);

		// Now return the module.
		return $m;
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
	protected function createDepartment() {
		$response = $this->call('POST', '/account/create-department', ['name' => 'phpunitDepartment',
															'shortname' => 'phpunitDepartment',
															'head'	=> 'headofdepartment',
															'description' => str_random(60),
															'facultyId'	=> 1]);

		$json = json_decode($response->getContent());
		$this->assertEquals(true, $json->success);

		// Return the  we just created.
		return Departments::find($json->departmentId);
	}

	/** 
	 * Function that updates specified department.
	 */
	protected function updateDepartment($id) {
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
	}

	/** 
	 * Function that creates an elective for a specified module.
	 */
	protected function createElective($mid) {
		$data = '';
		$d = array('classlecturer' => 'lecturer',
					'classmodule' => $mid,
					'classlimit' => 10);
		foreach($d as $key => $value) {
			$data = $data.$key.'='.$value.'&';
		}
		// TODO: Once elective creation is resolved change path below.
		$response = $this->call('POST', '/module-new', ['elecData' => $data]);

		$json = json_decode($response->getContent());
		$this->assertEquals(true, $json->success);

		// Return the Class we just created.
		return Classes::where('classmodule', $mid)->first();
	}
}
