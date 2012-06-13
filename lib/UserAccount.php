<?php


class UserAccount {
	public $email, $password, $firstName, $lastName;

	public function save($redis) {
		$redis->set($this->email, $this);
	}

	public static function getByEmailAddress($redis, $emailAddress) {
		return $redis->get($emailAddress);
	}

}