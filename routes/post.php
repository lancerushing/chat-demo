<?php

error_reporting(E_ALL | E_STRICT);

require_once "lib/UserAccount.php";
require_once "lib/Message.php";
require_once "lib/Redis.php";
require_once "lib/ChatThingy.php";

session_start();

$userAccount = $_SESSION['account'];
$message = new Message($userAccount->firstName, $_REQUEST["message"]);

$chat = new ChatThingy($redis);
$chat->post($message,  $_REQUEST['channel']);
$results = $chat->poll($userAccount, $_REQUEST);

echo json_encode($results);
