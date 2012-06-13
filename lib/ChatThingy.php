<?php

class ChatThingy {
	const CHAT_KEY_PREFIX = "chat";
	const USER_INDEX_KEY_PREFIX = "indexes";

	private $redis;

	public function __construct(Redis $redis) {
		$this->redis = $redis;
	}

	public function poll(UserAccount $userAccount, Array $params) {
		$channel = $params['channel'];

		$chatKey = $this->getChatKey($channel);
		$userIndexKey = $this->getUserIndexKey($userAccount->email);

		$previousIndex = $this->redis->hGet($userIndexKey, $channel);
		$currentIndex = $this->redis->lSize($chatKey);

		$results = $this->redis->lRange($chatKey, $previousIndex, $currentIndex);

		$this->redis->hSet($userIndexKey, $channel, $currentIndex);

		return $results;
	}

	private function getChatKey($channel) {
		return sprintf("%s:%s", self::CHAT_KEY_PREFIX, $channel);
	}

	private function getUserIndexKey($userId) {
		return sprintf("%s:%s", self::USER_INDEX_KEY_PREFIX, $userId);
	}

}