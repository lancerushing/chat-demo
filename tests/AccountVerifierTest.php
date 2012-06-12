<?php

require_once 'lib/AccountVerifier.php';

class AccountVerifierTest extends PHPUnit_Framework_TestCase {

	private $verifier;

	public function setup() {
		$this->verifier = new AccountVerifier();
	}

	public function testVerifyInput() {
		$this->verifier->verifyInput(array("email"=>"test@uptracs.com", "password1"=>"test12345",  "password2"=>"test12345"));
		$this->assertEquals(0, count($this->verifier->errors), implode(",", $this->verifier->errors));
	}

	public function testValidateEmail_Blank() {
		$method = new ReflectionMethod("AccountVerifier", "validateEmail");
		$method->setAccessible(TRUE);

		$method->invoke($this->verifier, "");
		$this->assertEquals("Email must be provided.", $this->verifier->errors["email"]);

	}

	public function testValidateEmail_BadFormat() {
		$method = new ReflectionMethod("AccountVerifier", "validateEmail");
		$method->setAccessible(TRUE);

		$method->invoke($this->verifier, "bad_format");
		$this->assertEquals("Email is invalid format.", $this->verifier->errors["email"]);

	}

	public function testValidateEmail_BadDomain() {
		$method = new ReflectionMethod("AccountVerifier", "validateEmail");
		$method->setAccessible(TRUE);

		$method->invoke($this->verifier, "lance@notavaliddomainblahblah.com");
		$this->assertEquals("Domain of 'notavaliddomainblahblah.com' could not be validated.", $this->verifier->errors["email"]);

	}


	public function testValidatePassword_Blank() {
		$method = new ReflectionMethod("AccountVerifier", "validatePassword");
		$method->setAccessible(TRUE);

		$method->invoke($this->verifier, "", "");
		$this->assertEquals("Passwords cannot be blank.", $this->verifier->errors["password"]);

	}

	public function testValidatePassword_Different() {
		$method = new ReflectionMethod("AccountVerifier", "validatePassword");
		$method->setAccessible(TRUE);

		$method->invoke($this->verifier, "this", "is not that");
		$this->assertEquals("Passwords do not match.", $this->verifier->errors["password"]);

	}

	public function testValidatePassword_Success() {
		$method = new ReflectionMethod("AccountVerifier", "validatePassword");
		$method->setAccessible(TRUE);

		$method->invoke($this->verifier, "this is a good password", "this is a good password");
		$this->assertFalse(isset($this->verifier->errors["password"]));

	}

	public function testStrongPassword_Fail() {
		$method = new ReflectionMethod("AccountVerifier", "strongPassword");
		$method->setAccessible(TRUE);

		$method->invoke($this->verifier, "short");
		$this->assertEquals("Must be at least eight characters.", $this->verifier->errors["password"]);

	}
	public function testStrongPassword_Success() {
		$method = new ReflectionMethod("AccountVerifier", "strongPassword");
		$method->setAccessible(TRUE);

		$method->invoke($this->verifier, "longenough");
		$this->assertFalse(isset($this->verifier->errors["password"]));

	}
}