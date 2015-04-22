<?php

class StudentViewTest extends TestCase {
	
	// Define user login credentials.
	private $username = 'student';
	private $password = 'abc123';

	public function testController() {
		// Log in so we have an authenticated user.
		$crawler = $this->client->request('POST', '/account/signin', ['username' => $this->username, 'password' => $this->password]);
		$this->assertRedirectedTo('/');

		// Create a dummy elective to use for testing.
		$elective = $this->createDummyElective();

		// Create dummy class.
		$class = $this->createDummyClass($elective->mid);

		// Try registering to elective.
		$this->register($elective->mid);

		// Now unregister from elective.
		$this->unregister($elective->mid);

		// Now request a new class.
		$this->request($elective->mid);

		// Delete dummy data.
		$class->delete();
		$elective->delete();
	}

	/**
	 * Function that registers user to elective.
	 */
	protected function register($id) {
		$response = $this->call('POST', '/account/register-elective', ['electiveId' => $id]);
		$json = json_decode($response->getContent());
		$this->assertEquals(true, $json->success);
	}

	/**
	 * Function that unregisters user to elective.
	 */
	protected function unregister($id) {
		$response = $this->call('POST', '/account/unregister-elective', ['electiveId' => $id]);
		$json = json_decode($response->getContent());
		$this->assertEquals(true, $json->success);
	}

	/**
	 * Function that requests a new class for elective.
	 */
	protected function request($id) {
		$response = $this->call('POST', '/account/request-elective', ['electiveId' => $id]);
		$json = json_decode($response->getContent());
		$this->assertEquals(true, $json->success);
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
		      'classlecturer'	=> 1,
		      'classmodule'		=> $id,
		      'classlimit'		=> 25));
	}
}
