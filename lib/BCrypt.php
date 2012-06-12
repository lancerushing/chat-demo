<?php

if(CRYPT_BLOWFISH != 1) {
	throw new Exception("bcrypt is not supported.");
}

class BCrypt {
	
	private $rounds;

	public function __construct($rounds=12) {
		if ($rounds < 4 || $rounds > 31) {
			throw new RuntimeException("bcrypt rounds must be between 4 and 31");
		}
		$this->rounds = $rounds;
	}

	public function hash($input) {

		return crypt($input, $this->getSalt());
	}

	public function verify($input, $existingHash) {
		$hash = crypt($input, $existingHash);
		return $hash === $existingHash;
	}

	private function getSalt() {

		return sprintf('$2a$%02d$%s', $this->rounds, $this->getRandomBytes());
	}

	private function getRandomBytes() {
		$bytes = openssl_random_pseudo_bytes(18); // bcrypt only needs 16, but due to encoding issues generate 2 extra
		$bytes = strtr(base64_encode($bytes), '+', '.'); // base65_encode uses + , translate to .
		return substr($bytes, 0, 22); // chop off any extra '=='

	}

}