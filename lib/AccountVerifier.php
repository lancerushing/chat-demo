<?php

require_once 'UserAccount.php';

class AccountVerifier {

	public $errors = array();

	public function verifyInput($input) {

		$this->validateEmail($input['email']);
		$this->validatePassword($input['password1'], $input['password2']);
	}

	private function validateEmail($emailAddress) {

		if (trim($emailAddress) === "") {
			$this->errors['email'] = 'Email must be provided.';
		} else {
			$emailAddress = filter_var($emailAddress, FILTER_VALIDATE_EMAIL);
			if ($emailAddress === FALSE) {
				$this->errors['email'] = 'Email is invalid format.';
			} else {
				if (UserAccount::getByEmailAddress($emailAddress) !== FALSE) {
					$this->errors['email'] = 'Email address is already in use.';
				}

				list($user, $domain) = explode('@', $emailAddress);
				if (!checkdnsrr($domain, 'mx')) {
					$this->errors['email'] = sprintf("Domain of '%s' could not be validated.", $domain);
				}
			}

		}
	}

	private function validatePassword ($password1, $password2) {
		if (trim($password1) === "") {
			$this->errors['password'] = 'Passwords cannot be blank.';
		} else {
			if ($password1 !== $password2) {
				$this->errors['password'] = "Passwords do not match.";	
			} else {
				$this->strongPassword($password1);				
			}
		}
	}

	private function strongPassword($inputPassword) {
		if (strlen($inputPassword) < 8) {
			$this->errors['password'] = "Must be at least eight characters.";
		}		
	}
}