<?php

require_once 'lib/ChatThingy.php';
require_once 'lib/UserAccount.php';
require_once 'lib/Message.php';

class ChatThingyTest extends PHPUnit_Framework_TestCase {

	/**
	 * @var ChatThingy
	 */
	private $object;
	
	/**
	 * @var Redis
	 */
	private $redis;

	protected function setUp() {
		$this->setUpRedis();
		$this->object = new ChatThingy($this->redis);
	}

	public function setUpRedis() {
		$this->redis = new Redis();
		$result = $this->redis->pconnect('127.0.0.1', 7777);
			
		if ($result !== TRUE) {
			throw new RuntimeException("Could not connect to DB.");
		}
		$this->redis->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_PHP);
	}

	public function testPush() {
		$userAccount = new UserAccount();
		$userAccount->email = "Fake User";
		$userAccount->name = "Fake User";
		
		$message = new Message($userAccount->name, "Fake Channel");
		$channel = "Fake Channel";
		$this->object->post($message, $channel);
		$results = $this->object->poll($userAccount, $channel);
		$this->assertEquals(array($message), $results);
		
		$this->redis->delete($this->redis->keys("*"));
	}
	
	public function testPoll() {
		$userAccount = new UserAccount();
		$userAccount->email = "Fake User";
		$channel = "Fake Channel";
		
		$results = $this->object->poll($userAccount, $channel);
		
		$this->assertEquals(array(), $results);
		
		
		
	}

	public function testGetChatKey() {
		$method = new ReflectionMethod("ChatThingy", "getChatKey");
		$method->setAccessible(TRUE);

		$key = $method->invoke($this->object, "ChannleName");
		$this->assertEquals("chat:ChannleName", $key);
	}

	public function testGetUserIndexKey() {
		$method = new ReflectionMethod("ChatThingy", "getUserIndexKey");
		$method->setAccessible(TRUE);

		$key = $method->invoke($this->object, "UserName");
		$this->assertEquals("indexes:UserName", $key);
	}

}
