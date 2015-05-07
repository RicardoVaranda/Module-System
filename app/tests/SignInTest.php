<?php

class SignInTest extends TestCase {
	
	// Define user login credentials.
	private $username = 'student';
	private $password = 'password';
	/**
	 * Test if the signIn page works correctly.
	 */
	public function testSignInPage() {
		// Load the page and check it loads correctly.
		$this->client->request('GET', '/account/signin');
		$this->assertTrue($this->client->getResponse()->isOk());
	}

	/**
	 * Test if the signIn form works correctly.
	 */
	public function testSignInForm() {
		
		$response = $this->action('POST', 'AccountController@postSignIn', ['username' => $this->username, 'password' => $this->password]);
		$this->assertRedirectedTo('/');
	}

	/**
	 * Test if the sign in form fails with incorrect credentials.
	 */
	public function testFailSignInForm() {
		$response = $this->action('POST', 'AccountController@postSignIn', ['username' => $this->username, 'password' => 'badpassword']);
		$this->assertRedirectedTo('/account/signin');
	}
}
