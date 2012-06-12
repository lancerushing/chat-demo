<?php

require_once '../lib/UserAccount.php';

session_start();
if (!isset($_SESSION['account'])) {
	header("Location: /login");
	exit;
}

$userAccount = $_SESSION['account'];


echo "Welcome " . $userAccount->firstName;

?>

<a href="/logout">Logout</a>
