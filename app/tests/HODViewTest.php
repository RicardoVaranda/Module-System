<?php

class HODViewTest extends TestCase {
	
	// Define user login credentials.
	private $username = 'hod';
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

		// Add a request to the module.
                $module->mrequests = '["20"]';
                $module->save();

		// Check if hod can see request.
		$crawler = $this->client->request('GET', '/');
		$this->assertTrue($this->client->getResponse()->isOk());
		$this->assertCount(1, $crawler->filter('p:contains("1 student has requested a new class.")'));

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

		// Create test lecturer.
		$lecturer = $this->createLecturer(true);

		// Try to create test lecturer with bad syntax.
		$this->createLecturer(false);

		// Remove the lecturer.
		$this->removeLecturer($lecturer->id);

		// Delete dummy data.
		$elective->delete();
		$module->delete();

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
	 * Function that creates a lecturer.
	 */
	protected function createLecturer($expected) {
		if ($expected) {
			$response = $this->call('POST', '/account/create-lecturer', ['name' => 'phpunitLecturer',
																'username' => 'phpunit123',
																'email' => 'phpunit@email.com']);

			$json = json_decode($response->getContent());
			$this->assertEquals($expected, $json->success);

			// Return the lecturer we just created.
			return User::find($json->id);
		} else {
			$response = $this->call('POST', '/account/create-lecturer', ['name' => 'phpunitLecturer',
															'username' => 'phpunit123',
															'email' => 'phpunitemail.com']);

			$json = json_decode($response->getContent());
			$this->assertEquals($expected, $json->success);
		}
	}

	/** 
	 * Function that removes a lecturer.
	 */
	protected function removeLecturer($id) {
		$response = $this->call('POST', '/account/remove-lecturer', ['id' => $id]);

		$json = json_decode($response->getContent());
		$this->assertEquals(true, $json->success);
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

