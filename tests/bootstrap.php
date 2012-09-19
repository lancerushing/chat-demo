<?php

function startUpRedis() {
	$pidfile = tempnam(sys_get_temp_dir(), "redis_pid_");
	$cmd = sprintf("redis-server %s/redis.conf > %s 2>&1 & echo $! >> %s", __DIR__ , "/dev/null", $pidfile);
	exec($cmd);
}
function getRedis() {
	$redis = new Redis();
	$result = $redis->pconnect('127.0.0.1', 7777);

	if ($result !== TRUE) {
		throw new RuntimeException("Could not connect to DB.");
	}
	$redis->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_PHP);
	return $redis;
}

	function cleanRedis() {
	$redis = getRedis();
	$redis->delete($redis->keys("*"));
}

startUpRedis();
