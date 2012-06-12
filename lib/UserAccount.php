<?php


class UserAccount {
	public $email, $password, $firstName, $lastName;

	public function save() {
		// TODO make better
		file_put_contents("/tmp/" . $this->email, serialize($this));

	}

	public static function getByEmailAddress($emailAddress) {
		$testFileName = "/tmp/" . $emailAddress;
		if (is_file($testFileName)) {
			return unserialize(file_get_contents($testFileName));
		}

		return false;

	}

}