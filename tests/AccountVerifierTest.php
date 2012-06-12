<?php

require_once 'lib/AccountVerifier.php';

class AccountVerifierTest extends PHPUnit_Framework_TestCase {

	private $verifier;

	public function setup() {
		$this->verifier = new AccountVerifier();
	}


	public function testStrongPassword() {
		$method = new ReflectionMethod("AccountVerifier", "strongPassword");
		$method->setAccessible(TRUE);

		$method->invoke($this->verifier, "short");

		$this->assertEquals("Must be at least eight characters.", $this->verifier->errors["password"]);

	}
}