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
		$this->redis = getRedis();
		$this->object = new ChatThingy($this->redis);
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
		
		cleanRedis();
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
