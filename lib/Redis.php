<?php


$redis = new Redis();
$result = $redis->pconnect('127.0.0.1', 6379);
if ($result !== TRUE) {
		throw new RuntimeException("Could not connect to DB.");
}
$redis->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_PHP); 

