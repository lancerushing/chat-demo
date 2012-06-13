<?php

error_reporting(E_ALL | E_STRICT);

require_once "lib/UserAccount.php";
require_once "lib/Message.php";
require_once "lib/Redis.php";
require_once "lib/ChatThingy.php";

session_start();

$chat = new ChatThingy($redis);
$results = $chat->poll($_SESSION['account'], $_REQUEST['channel']);

echo json_encode($results);
