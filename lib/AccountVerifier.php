<?php

class AccountVerifier {

	public $errors = array();

	public function verifyAccount($input) {

		$this->validateEmail($input['email']);
		$this->validatePassword($input['password1'], $input['password2']);
	}

	private function validateEmail($emailAddress) {

		if (trim($emailAddress) === "") {
			$this->errors['email'] = 'Email must be provided.';
		} else {
			$emailAddress = filter_var($emailAddress, FILTER_VALIDATE_EMAIL);
			// TODO check for existing user

			list($user, $domain) = explode('@', $emailAddress);
			if (!checkdnsrr($domain, 'mx')) {
				$this->errors['email'] = sprintf("Domain of '%s' could not be validated.", $domain);
			}

		}
	}

	private function validatePassword ($password1, $password2) {
		if (trim($password1) === "") {
			$this->errors['password'] = 'Passwords cannot be blank.';
		} else {
			if ($password1 !== $password2) {
				$this->errors['password'] = "Passwords do not match";	
			} elseif ($this->strongPassword($password1)) {
				$this->errors['password'] = "Password is weak";
			}
		}
	}

	private function strongPassword($inputPassword) {
		if (strlen($inputPassword) < 8) {
			$this->errors['password'] = "Must be at least eight characters.";
		}		
	}
}