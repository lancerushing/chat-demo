<?php

require_once 'lib/BCrypt.php';

class BCryptTest extends PHPUnit_Framework_TestCase {

    /**
     * @var BCrypt
     */
    private $bCrypt;

	public function setup() {
		$this->bCrypt = new BCrypt();
	}

	public function testConstructThrowsException () {
		$this->setExpectedException("RunTimeException");
		 new BCrypt(32);

	}

	public function testHash() {
		$hash = $this->bCrypt->hash("ThisIsATest");
	}

	public function testVerify() {
		$password = "This is my test password.";
		$hash = $this->bCrypt->hash($password);

		$result = $this->bCrypt->verify($password, $hash);
		$this->assertTrue($result);

		$result = $this->bCrypt->verify("This is not the password.", $hash);
		$this->assertFalse($result);
	}


	public function testGetSalt() {

		$method = new ReflectionMethod("BCrypt", "getSalt");
		$method->setAccessible(TRUE);

		$salt = $method->invoke($this->bCrypt);
	
		$this->assertEquals('$2a$', substr($salt, 0, 4));
		$this->assertEquals('$12$', substr($salt, 3, 4));

		$this->assertEquals(29, strlen($salt));
		
	}


	public function testGetRandomBytes() {

		$method = new ReflectionMethod("BCrypt", "getRandomBytes");
		$method->setAccessible(TRUE);

		$randomBytes = $method->invoke($this->bCrypt);

		$this->assertEquals(22, strlen($randomBytes));
		
	}
}