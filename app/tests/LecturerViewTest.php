<?php

class LecturerViewTest extends TestCase {
	
	// Define user login credentials.
	private $username = 'lecturer';
	private $password = 'password';

	public function testController() {
		// Log in so we have an authenticated user.
		$crawler = $this->client->request('POST', '/account/signin', ['username' => $this->username, 'password' => $this->password]);
		$this->assertRedirectedTo('/');

		// Create a dummy elective to use for testing.
		$elective = $this->createDummyElective();

		// Create dummy class.
		$class = $this->createDummyClass($elective->mid);

		// Create dummy student.
		$student = $this->createDummyStudent();

		// Enroll student to class.
		$studentelectives = array();
		$studentelective = array('electiveId' => $elective->mid,
							'classId' => $class->classid,
							'date' => date('Y-m-d'));
		array_push($studentelectives, $studentelective);
		$student->electives = json_encode($studentelectives);
		$student->save();

		$class->classstudents = json_encode(array($student->id));
		$class->classcurrent = 1;
		$class->save();

		// Load class.
		$this->loadClass($class->classid);

		// Update class.
		$this->updateClass($class->classid, true, 5);

		// Update class with incorrect values.
		$this->updateClass($class->classid, false, 'five');

		// Remove student from class.
		$this->removeStudent($class->classid, $student->id);

		// Delete dummy data.
		$class->delete();
		$elective->delete();
		$student->delete();
	}

	/**
	 * Function that loads a class.
	 */
	protected function loadClass($id, $expected = 1) {
		$response = $this->call('POST', '/account/load-class', ['classId' => $id]);
		$json = json_decode($response->getContent());
		$this->assertEquals(true, $json->success);
		$this->assertEquals($expected, count($json->students));
	}

	/**
	 * Function that updates a class.
	 */
	protected function updateClass($id, $expected, $updateVal) {
		$response = $this->call('POST', '/account/update-class', ['classId' => $id, 'limit' => $updateVal]);
		$json = json_decode($response->getContent());
		$this->assertEquals($expected, $json->success);
		if($expected) {
			$this->assertEquals(4, $json->space);
		}

	}

	/**
	 * Function that removes student from class.
	 */
	protected function removeStudent($id, $studentid) {
		$response = $this->call('POST', '/account/remove-student', ['classId' => $id, 'studentId' => $studentid]);
		$json = json_decode($response->getContent());
		$this->assertEquals(true, $json->success);
		$this->assertEquals(5, $json->space);
	}

	/**
	 *	Function that creates a dummy elective.
	 */
	protected function createDummyElective() {
		return Modules::create(array(
		      'mfulltitle'      => 'name',
		      'mshorttitle'		=> 'shorttitle',
		      'mdescription'     =>  'description',
		      'mcode'     =>  'code',
		      'mfieldofstudy'     =>  'field',
		      'mcoordinator'     =>  'coordinator',
		      'mlevel'     =>  'level',
		      'mcredits'     =>  5,
		      'melective'	=> true,
		      'departmentid' => Auth::user()->department));
	}

	/**
	 * Function that creates dummy class.
	 */
	protected function createDummyClass($id) {
		return Classes::create(array(
		      'classlecturer'	=> Auth::user()->id,
		      'classmodule'		=> $id,
		      'classlimit'		=> 25));
	}

	/**
	 * Function that creates dummy student.
	 */
	protected function createDummyStudent() {
		return User::create(array(
		      'username'	=> 'testuser',
		      'name'		=> 'testuser',
		      'email'		=> 'testuser@email.com',
		      'rank'			=> 0,
			  'department'	=> Auth::user()->department,
			  'password'		=> Hash::make('abc123'),
			  'active'		=> 1));
	}
}
