<?php

require_once '../lib/UserAccount.php';

session_start();
if (!isset($_SESSION['account'])) {
	header("Location: /login");
	exit;
}

$userAccount = $_SESSION['account'];


require_once "../templates/header.php";

echo "Welcome " . $userAccount->firstName;

require_once "../templates/footer.php";

 