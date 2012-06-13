<?php

error_reporting(E_ALL | E_STRICT);


require_once "lib/UserAccount.php";
require_once "lib/Message.php";

session_start();


$userAccount = $_SESSION['account'];

$redis = new Redis();
$result = $redis->pconnect('127.0.0.1', 6379);
if ($result !== TRUE) {
		throw new RuntimeException("Could not connect to DB.");
}
$redis->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_PHP); 

$prefix = "chat";
$key = sprintf("%s:%s", $prefix , $_REQUEST['channel']);

$indexKey = "indexes:" . $userAccount->email;

$previousIndex = $redis->hGet($indexKey, $_REQUEST['channel']) ;
$currentIndex = $redis->lSize($key) ;
$results = $redis->lRange($key, $previousIndex, $currentIndex);
$redis->hSet($indexKey, $_REQUEST['channel'], $currentIndex );

echo json_encode($results);

