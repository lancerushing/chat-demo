<?php


class UserAccount {
	public $email, $password, $firstName, $lastName;

	public function save() {
		$redis = self::connect();
		$redis->set($this->email, $this);
		

	}

	public static function connect() {

		$redis = new Redis();
		$result = $redis->pconnect('127.0.0.1', 6379);
		if ($result !== TRUE) {
			throw new RuntimeException("Could not connect to DB.");
		}
		$redis->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_PHP); 
		return $redis;
	}

	public static function getByEmailAddress($emailAddress) {
		$redis = self::connect();
		return $redis->get($emailAddress);

	}

}